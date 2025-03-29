<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Materiel;
use App\Models\Ordinateur;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AffectationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Affectation::with(['utilisateur', 'materiel']);

        // Vérifier si une recherche est effectuée
        $search = $request->search;
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;

            $query->whereHas('utilisateur', function ($q) use ($search) {
                $q->where('nom', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('departement', 'LIKE', "%$search%")
                    ->orWhere('telephone', 'LIKE', "%$search%");
            })
                ->orWhereHas('materiel', function ($q) use ($search) {
                    $q->where('fabricant', 'LIKE', "%$search%")
                        ->orWhere('num_serie', 'LIKE', "%$search%")
                        ->orWhere('type', 'LIKE', "%$search%")
                        ->orWhere('etat', 'LIKE', "%$search%");
                })
                ->orWhere('date_affectation', 'LIKE', "%$search%")
                ->orWhere('statut', 'LIKE', "%$search%");
        }

        // Récupérer les résultats paginés
        $affectations = $query->orderBy('created_at', 'desc')
                            ->orderBy('statut')
                            ->paginate(50)
                            ->appends(["search" => $search]);

        return view('affectations.index', compact('affectations', 'search'));
    }

    public function userExists($utilisateur)
    {
        $utilisateur = Utilisateur::find($utilisateur);
        if (!$utilisateur) {
            return redirect()->route('affectation.index')->with('error', 'Utilisateur introuvable.');
        }

        return view('affectations.createExists', compact('utilisateur'));
    }

    

    public function getByNum($num_serie)
    {
        // Rechercher le matériel par numéro de série
        $materiel = Materiel::where('num_serie', $num_serie)->first();

        if (!$materiel) {
            return response()->json(['error' => 'Matériel non trouvé'], 404);
        }

        // Données de base du matériel
        $data = [
            'id' => $materiel->id,
            'fabricant' => $materiel->fabricant,
            'type' => $materiel->type,
            'etat' => $materiel->etat,
        ];

        // Si c'est un ordinateur (PC Portable ou PC Bureau), ajouter les détails spécifiques
        if ($materiel->type === 'Pc Portable' || $materiel->type === 'Pc Bureau') {
            $ordinateur = Ordinateur::where('materiel_id', $materiel->id)->first();
            if ($ordinateur) {
                $data['processeur'] = $ordinateur->processeur;
                $data['ram'] = $ordinateur->ram;
                $data['stockage'] = $ordinateur->stockage;
            }
        }

        return response()->json($data);
    }

    public function upload(Request $request, Affectation $affectation)
    {
        $request->validate([
            'fiche_affectation' => 'required|mimes:jpeg,png,jpg,pdf|max:6000', // Validation fichier image
        ]);

        // Stocker l'image
        $path = $request->file('fiche_affectation')->store('affectations', 'public');

        // Mettre à jour la base de données
        $affectation->update(['fiche_affectation' => $path]);

        return back()->with('success', 'Fiche affectation mise à jour avec succès !');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('affectations.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Vérifier si l'utilisateur existe déjà
        $utilisateur = Utilisateur::firstOrCreate(
            ['email' => $request->email],
            [
                'nom' => $request->nom,
                'fonction' => $request->fonction,
                'telephone' => $request->telephone,
                'departement' => $request->departement,
            ]
        );

        // Récupérer le matériel
        $materiel = Materiel::findOrFail($request->id_materiel);

        // Récupérer toutes les affectations précédentes du matériel
        $anciennesAffectations = Affectation::where('materiel_id', $materiel->id)->get();

        // Si des affectations existent, les passer à "NON AFFECTE"
        if ($anciennesAffectations->isNotEmpty()) {
            foreach ($anciennesAffectations as $affectation) {
                $affectation->update(['statut' => 'NON AFFECTE']);
            }
            $statutAffectation = 'REAFFECTE';
        } else {
            $statutAffectation = 'AFFECTE';
        }

        // Créer la nouvelle affectation
        Affectation::create([
            'utilisateur_id' => $utilisateur->id,
            'materiel_id' => $materiel->id,
            'chantier' => $request->chantier,
            'utilisateur1' => $request->utilisateur,
            'date_affectation' => $request->date_affectation,
            'statut' => $statutAffectation,
        ]);

        return redirect()->route('affectation.index')->with('success', 'Affectation créée avec succès.');
    }


    public function storeExists(Request $request)
    {
        // Validation des données reçues
        $request->validate([
            'nom' => 'required|string|max:255',
            'fonction' => 'required|string|max:255',
            'departement' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'date_affectation' => 'date',
            'chantier' => 'nullable|string|max:255',
            'num_serie' => 'required|string|max:255',
            'id_materiel' => 'required|exists:materiels,id',
        ]);

        // Récupérer l'utilisateur
        $utilisateur = Utilisateur::where('nom', $request->nom)
            ->where('email', $request->email)
            ->first();

        if (!$utilisateur) {
            return redirect()->back()->with('error', 'Utilisateur introuvable.');
        }
        $materiel = Materiel::where('num_serie' ,$request->num_serie)->get()->first();
        $ancienneAffectation = Affectation::where('materiel_id', $materiel->id)
            ->latest('date_affectation') // Récupérer la dernière affectation enregistrée
            ->first();
        

        // Si une affectation précédente existe, on doit définir son statut sur "NON AFFECTE"
        if ($ancienneAffectation) {
            $ancienneAffectation->update(['statut' => 'NON AFFECTE']);
            $statutAffectation = 'REAFFECTE'; // Si le matériel a déjà été affecté, on marque la nouvelle affectation comme "REAFFECTE"
        } else {
            $statutAffectation = 'AFFECTE'; // Si le matériel n'a jamais été affecté, on marque la nouvelle affectation comme "AFFECTE"
        }

        // Création de l'affectation avec `create()`
        Affectation::create([
            'utilisateur_id' => $utilisateur->id,
            'date_affectation' => $request->date_affectation,
            'chantier' => $request->chantier,
            'utilisateur1' => $request->utilisateur,
            'statut'=>$statutAffectation,
            'materiel_id' => $request->id_materiel,
        ]);

        return redirect()->route('affectation.show', $utilisateur)->with('success', 'Affectation ajoutée avec succès.');
    }

    public function show($id)
    {
        // Récupérer l'utilisateur avec ses affectations
        $utilisateur = Utilisateur::with('affectations.materiel')->find($id);

        // Vérifier si l'utilisateur existe
        if (!$utilisateur) {
            return redirect()->route('affectation.index')->with('error', 'Utilisateur introuvable.');
        }

        // Passer les données à la vue
        return view('affectations.show', compact('utilisateur'));
    }



    public function edit(Affectation $affectation)
    {
        // Charger les informations de l'utilisateur et du matériel associés
        $utilisateur = $affectation->utilisateur;

        // Charger le matériel avec la relation "ordinateur" préchargée
        $materiel = $affectation->materiel->load('ordinateur');

        // Vérifier si le matériel est un ordinateur (PC Bureau ou PC Portable)
        $ordinateur = null;
        if ($materiel && in_array($materiel->type, ['Pc Bureau', 'Pc Portable'])) {
            $ordinateur = $materiel->ordinateur; // Utiliser la relation préchargée
        }

        return view('affectations.edit', compact('affectation', 'utilisateur', 'materiel', 'ordinateur'));
    }


    public function update(Request $request, Affectation $affectation)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'fonction' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'departement' => 'required|string|max:255',
            'chantier' => 'nullable|string|max:255',
            'date_affectation' => 'required|date',
            'num_serie' => 'required|string|max:255', // Le numéro de série pour trouver le nouveau matériel
            'statut' => 'required|string|in:AFFECTE,REAFFECTE,NON AFFECTE',
        ]);

        // Trouver le nouveau matériel en fonction du numéro de série
        $nouveauMateriel = Materiel::where('num_serie', $request->num_serie)->first();

        if (!$nouveauMateriel) {
            return redirect()->back()->with('error', 'Matériel introuvable avec ce numéro de série.');
        }

        // Mettre à jour l'utilisateur
        $utilisateur = $affectation->utilisateur;
        $utilisateur->update([
            'nom' => $request->nom,
            'fonction' => $request->fonction,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'departement' => $request->departement,
        ]);

        // Vérifier si le matériel est déjà affecté à un autre utilisateur
        $ancienneAffectation = Affectation::where('materiel_id', $nouveauMateriel->id)
            ->where('id', '!=', $affectation->id) // Exclure l'affectation actuelle
            ->orderByDesc('date_affectation')
            ->first();

        // Mettre à jour l'ancienne affectation (si elle existe)
        if ($ancienneAffectation) {
            $ancienneAffectation->update([
                'statut' => 'NON AFFECTE', // Mettre à jour le statut de l'ancienne affectation
            ]);
        }

        // Mettre à jour l'affectation actuelle
        $affectation->update([
            'materiel_id' => $nouveauMateriel->id, // Changer l'ID du matériel
            'chantier' => $request->chantier,
            'utilisateur1' => $request->utilisateur,
            'date_affectation' => $request->date_affectation,
            'statut' => $request->statut, // Utiliser le statut fourni dans la requête
        ]);

        // Redirection avec un message de succès
        return redirect()->route('affectation.index')->with('success', 'Affectation mise à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Affectation $affectation)
    {
        // Récupérer l'utilisateur associé à l'affectation
        $utilisateur = $affectation->utilisateur;

        // Supprimer l'affectation
        $affectation->delete();

        // Vérifier si l'utilisateur a encore d'autres affectations
        if ($utilisateur && $utilisateur->affectations()->count() === 0) {
            $utilisateur->delete();
        }

        // Rediriger avec un message de succès
        return redirect()->route('affectation.index')->with('message', "L'affectation a été supprimée avec succès.");
    }
}
