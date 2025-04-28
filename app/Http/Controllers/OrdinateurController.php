<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Ordinateur;
use App\Models\Materiel;
use Illuminate\Http\Request;

class OrdinateurController extends Controller
{

    public function index(Request $request)
    {
        // Valider le paramètre de recherche
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        // Terme de recherche
        $search = $request->input('search');

        // Requête pour récupérer les ordinateurs (matériels de type PC + leurs specs)
        $ordinateurs = Materiel::whereIn('type', ['PC Bureau', 'PC Portable'])
            ->join('ordinateurs', 'materiels.id', '=', 'ordinateurs.materiel_id')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('materiels.fabricant', 'like', "%{$search}%")
                        ->orWhere('materiels.num_serie', 'like', "%{$search}%")
                        ->orWhere('materiels.num_commande', 'like', "%{$search}%")
                        ->orWhere('materiels.etat', 'like', "%{$search}%")
                        ->orWhere('materiels.type', 'like', "%{$search}%")
                        ->orWhere('ordinateurs.ram', 'like', "%{$search}%")
                        ->orWhere('ordinateurs.stockage', 'like', "%{$search}%")
                        ->orWhere('ordinateurs.processeur', 'like', "%{$search}%");
                });
            })
            ->select(
                'materiels.id as materiel_id',
                'ordinateurs.id as ordinateur_id',
                'materiels.fabricant',
                'materiels.type',
                'materiels.num_serie',
                'materiels.num_commande',
                'materiels.etat',
                'ordinateurs.ram',
                'ordinateurs.stockage',
                'ordinateurs.processeur'
            )
            ->get();

        // Récupération des dernières affectations pour les matériels concernés
        $lastAffectations = Affectation::whereIn('materiel_id', $ordinateurs->pluck('materiel_id'))
            ->orderByDesc('date_affectation')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('materiel_id');


        // Ajout du statut d'affectation ou "NON AFFECTE"
        foreach ($ordinateurs as $ordinateur) {
            $last = $lastAffectations->get($ordinateur->materiel_id)?->first();
            $ordinateur->statut = $last ? $last->statut : 'NON AFFECTE';
        }
        $ordinateurs = $ordinateurs->sortBy(function ($item) {
            // "NON AFFECTE" vient en premier (0), les autres ensuite (1)
            return $item->statut === 'NON AFFECTE' ? 0 : 1;
        })->values();
        // Retour à la vue
        return view('materiels.ordinateurs.index', compact('ordinateurs', 'search'));
    }


    public function create()
    {
        return view('materiels.ordinateurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'fabricant' => 'required|string',
            'type' => 'required|string',
            'num_serie' => 'required|unique:materiels,num_serie',
            'num_commande' => 'required',
            'etat' => 'required|string',
        ]);

        // Créer un nouveau matériel sans statut
        $materiel = Materiel::create([
            'fabricant' => $request->fabricant,
            'type' => $request->type,
            'num_serie' => $request->num_serie,
            'num_commande' => $request->num_commande,
            'etat' => $request->etat,
        ]);

        // Créer un ordinateur associé au matériel
        Ordinateur::create([
            'materiel_id' => $materiel->id, // Associer l'ordinateur au matériel créé
            'processeur' => $request->processeur,
            'ram' => $request->ram,
            'stockage' => $request->stockage,
        ]);

        // Retourner à la liste des ordinateurs avec un message de succès
        return redirect()->route('ordinateurs.index')->with('message', 'Ordinateur ajouté avec succès.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Ordinateur $ordinateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ordinateur $ordinateur)
    {
        return view('materiels.ordinateurs.edit', compact('ordinateur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ordinateur $ordinateur)
    {
        $request->validate([
            'fabricant' => 'required|string',
            'type' => 'required|string',
            'num_serie' => 'required|unique:materiels,num_serie,' . $ordinateur->materiel->id,
            'num_commande' => 'required',
            'etat' => 'required|string',
        ]);

        // Mettre à jour les informations du matériel associé
        $ordinateur->materiel->update([
            'fabricant' => $request->fabricant,
            'type' => $request->type,
            'num_serie' => $request->num_serie,
            'num_commande' => $request->num_commande,
            'etat' => $request->etat,
        ]);

        // Mettre à jour les informations spécifiques à l'ordinateur
        $ordinateur->update([
            'processeur' => $request->processeur,
            'ram' => $request->ram,
            'stockage' => $request->stockage,
        ]);

        return redirect()->route('ordinateurs.index')->with('message', 'Ordinateur mis à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ordinateur $ordinateur)
    {
        // Récupérer le matériel associé à l'ordinateur
        $materiel = $ordinateur->materiel;

        if (!$materiel) {
            return redirect()->back()->with('error', 'Matériel introuvable.');
        }

        // Vérification directe auprès de la table Materiel
        // Dans l'index, vous mettez à jour le statut affiché, mais pas nécessairement 
        // le champ statut du matériel lui-même

        // Récupérons le statut courant basé sur la dernière affectation
        $derniereAffectation = Affectation::where('materiel_id', $materiel->id)
            ->orderByDesc('date_affectation')
            ->orderByDesc('created_at')
            ->first();

        $statutCourant = $derniereAffectation ? $derniereAffectation->statut : 'NON AFFECTE';
        // Valider selon le statut courant
        if (in_array($statutCourant, ['AFFECTE', 'REAFFECTE'])) {
            return redirect()->back()
                ->with('error', 'Ce matériel est actuellement affecté (statut: ' . $statutCourant . '). Vous ne pouvez pas le supprimer.');
        }

        // Si le statut est NON AFFECTE, on peut supprimer
        // Supprimer toutes les affectations associées
        Affectation::where('materiel_id', $materiel->id)->delete();

        // Supprimer l'ordinateur et le matériel
        $ordinateur->delete();
        $materiel->delete();

        return redirect()->route('ordinateurs.index')
            ->with('message', 'Ordinateur supprimé avec succès.');
    }
}
