<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Materiel;
use App\Models\Notification;
use App\Models\Type;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->role === 'admin'){
            $notifications = Notification::where('is_read' ,false)->count();
            $totalMateriels = Materiel::count();
            $totalUtilisateurs = Utilisateur::count();
            $years = Affectation::selectRaw('year(date_affectation) as year')->distinct()->orderBy('year' ,'desc')->pluck('year');
            $types = Type::all()->select('type')->pluck('type');
            return view('dashboard.index' ,compact('totalMateriels' , 'totalUtilisateurs' ,'years' , 'types' , 'notifications'));
        }else{
            return redirect()->route('recrutements.index');
        }
    }

    public function getChartData()
    {
        // Récupérer les données pour le graphique
        $types = Type::all()->select('type')->pluck('type');
        $counts = [];

        foreach ($types as $type) {
            $counts[] = Materiel::where('type', $type)->count();
        }

        // Définir les couleurs et styles pour chaque type
        $backgroundColors = [
            '#1d2838', // Pc Bureau
            '#f4d103', // Pc Portable
            '#1f1e24', // Imprimante
            'rgba(85, 85, 85, 0.6)', // Routeur
        ];

        $borderColors = [
            '#1d2838',
            '#f4d103',
            '#1f1e24',
            'rgba(85, 85, 85, 1)',
        ];

        // Préparer les données à retourner
        $data = [
            'labels' => $types,
            'datasets' => [
                [
                    'label' => 'Nombre de matériels par type',
                    'data' => $counts,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => $borderColors,
                    'borderWidth' => 1,
                    'hoverBackgroundColor' => array_map(function ($color) {
                        return str_replace('0.2', '0.4', $color); // Changement d'opacité au survol
                    }, $backgroundColors),
                    'hoverBorderColor' => $borderColors,
                ],
            ],
        ];

        // Retourner les données au format JSON
        return response()->json($data);
    }

    public function getAffectationStats()
    {
        // Récupérer la dernière affectation (par date ou ID) de chaque matériel
        $latestAffectations = Affectation::select(DB::raw('MAX(id) as latest_id'))
            ->groupBy('materiel_id');

        // Affectations avec statut "AFFECTE" ou "REAFFECTE"
        $materielsAffectes = Affectation::whereIn('id', $latestAffectations)
            ->whereIn('statut', ['AFFECTE', 'REAFFECTE'])
            ->count();

        // Affectations dont le dernier statut n'est PAS "AFFECTE" ou "REAFFECTE"
        $materielsNonAffectesViaAffectation = Affectation::whereIn('id', $latestAffectations)
            ->whereNotIn('statut', ['AFFECTE', 'REAFFECTE'])
            ->count();

        // Matériels qui n'ont JAMAIS été affectés
        $materielsJamaisAffectes = Materiel::whereDoesntHave('affectations')->count();

        // Total non affecté = matériels non affectés (statut autre) + jamais affectés
        $materielsNonAffectes = $materielsNonAffectesViaAffectation + $materielsJamaisAffectes;

        $labels = ['Non Affecté', 'Affecté ou Réaffecté'];
        $backgroundColors = ['rgba(43,88,112 ,0.6)', '#f5d004'];
        $hoverBackgroundColors = ['rgb(43,88,112)', '#f5d004'];

        $data = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Nombre de matériels',
                    'data' => [$materielsNonAffectes, $materielsAffectes],
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => '#fff',
                    'borderWidth' => 2,
                    'hoverBackgroundColor' => $hoverBackgroundColors,
                    'hoverBorderColor' => '#333'
                ]
            ]
        ];

        return response()->json($data);
    }

    public function getAffectationByMonth(Request $request)
    {
        $year = $request->input('year', now()->year); // Récupérer l'année, sinon année actuelle

        $affectationsParMois = Affectation::selectRaw('MONTH(date_affectation) as mois, COUNT(*) as total')
            ->whereYear('date_affectation', $year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Créer un tableau avec 12 mois initialisés à 0
        $moisNoms = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        $affectationsParMoisData = array_fill(0, 12, 0);

        foreach ($affectationsParMois as $affectation) {
            $affectationsParMoisData[$affectation->mois - 1] = $affectation->total;
        }

        $data = [
            'labels' => $moisNoms,
            'datasets' => [
                [
                    'label' => 'Nombre d\'affectations',
                    'data' => $affectationsParMoisData,
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderWidth' => 2,
                    'pointBackgroundColor' => 'rgba(75, 192, 192, 1)',
                    'tension' => 0.4
                ]
            ]
        ];

        return response()->json($data);
    }
}