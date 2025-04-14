<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Utilisateur;
use App\Models\Materiel;
use App\Models\Ordinateur;
use App\Models\Imprimante;
use App\Models\Telephone;
use App\Models\Recrutement;
use App\Models\Notification;
use Illuminate\Http\Request;

class trashController extends Controller
{
    public function index()
    {
        // Récupérer les affectations supprimées avec les relations utilisateur et matériel
        $affectations = Affectation::onlyTrashed()
            ->with(['utilisateur' => function ($query) {
                $query->withTrashed();
            }, 'materiel' => function ($query) {
                $query->withTrashed();
            }])
            ->orderBy('deleted_at', 'desc')
            ->get();

        // Récupérer les ordinateurs supprimés
        $ordinateurs = Ordinateur::onlyTrashed()
            ->with(['materiel' => function ($query) {
                $query->withTrashed();
            }])
            ->orderBy('deleted_at', 'desc')
            ->get();

        // Récupérer les imprimantes supprimées
        $imprimantes = Imprimante::onlyTrashed()
            ->with(['materiel' => function ($query) {
                $query->withTrashed();
            }])
            ->orderBy('deleted_at', 'desc')
            ->get();

        // Récupérer les téléphones supprimés
        $telephones = Telephone::onlyTrashed()
            ->with(['materiel' => function ($query) {
                $query->withTrashed();
            }, 'materiel.affectations' => function ($query) {
                $query->withTrashed()->latest('date_affectation')->take(1);
            }, 'materiel.affectations.utilisateur' => function ($query) {
                $query->withTrashed();
            }])
            ->orderBy('deleted_at', 'desc')
            ->get();

        // Récupérer les périphériques supprimés (matériels qui ne sont ni ordinateurs, ni imprimantes, ni téléphones)
        $peripheriques = Materiel::onlyTrashed()
            ->whereNotIn('type', ['PC Bureau', 'PC Portable', 'Imprimante', 'Telephone'])
            ->orderBy('deleted_at', 'desc')
            ->get();

        // Récupérer les recrutements supprimés
        $recrutements = Recrutement::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        // Récupérer les notifications supprimées
        $notifications = Notification::onlyTrashed()
            ->with('recrutement')
            ->orderBy('deleted_at', 'desc')
            ->get();

        // Vérifier si les relations existent encore
        foreach ($affectations as $affectation) {
            if ($affectation->utilisateur_id && !Utilisateur::withTrashed()->find($affectation->utilisateur_id)) {
                $affectation->utilisateur = null;
            }
            if ($affectation->materiel_id && !Materiel::withTrashed()->find($affectation->materiel_id)) {
                $affectation->materiel = null;
            }
        }

        return view('trash.index', compact(
            'affectations',
            'ordinateurs',
            'imprimantes',
            'telephones',
            'peripheriques',
            'recrutements',
            'notifications'
        ));
    }

    public function forceDelete($type, $id)
    {
        switch ($type) {
            case 'affectation':
                $item = Affectation::onlyTrashed()->findOrFail($id);
                break;
            case 'ordinateur':
                $item = Ordinateur::onlyTrashed()->findOrFail($id);
                break;
            case 'imprimante':
                $item = Imprimante::onlyTrashed()->findOrFail($id);
                break;
            case 'telephone':
                $item = Telephone::onlyTrashed()->findOrFail($id);
                break;
            case 'peripherique':
                $item = Materiel::onlyTrashed()->findOrFail($id);
                break;
            case 'recrutement':
                $item = Recrutement::onlyTrashed()->findOrFail($id);
                break;
            case 'notification':
                $item = Notification::onlyTrashed()->findOrFail($id);
                break;
            default:
                return redirect()->route('trash.index')
                    ->with('error', 'Type d\'élément invalide.');
        }

        $item->forceDelete();

        return redirect()->route('trash.index')
            ->with('success', 'L\'élément a été supprimé définitivement.');
    }
}
