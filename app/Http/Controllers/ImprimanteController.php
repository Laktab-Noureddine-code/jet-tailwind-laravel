<?php

namespace App\Http\Controllers;

use App\Models\Imprimante;
use App\Models\Materiel;
use App\Models\Affectation;
use Illuminate\Http\Request;

class ImprimanteController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        // Récupérer le terme de recherche
        $search = $request->input('search');

        // Récupérer les imprimantes avec leurs toners associés et l'utilisateur affecté
        $imprimantes = Materiel::where('type', 'IMPRIMANTE')
            ->join('imprimantes', 'materiels.id', '=', 'imprimantes.materiel_id')
            ->leftJoin('affectations', function ($join) {
                $join->on('materiels.id', '=', 'affectations.materiel_id')
                    ->whereIn('affectations.statut', ['AFFECTE', 'REAFFECTE'])
                    ->whereRaw('affectations.id = (select id from affectations where materiel_id = materiels.id and statut in ("AFFECTE", "REAFFECTE") order by date_affectation desc, created_at desc limit 1)');
            })
            ->leftJoin('utilisateurs', 'affectations.utilisateur_id', '=', 'utilisateurs.id')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    // Recherche par mot-clé dans les champs des matériels, imprimantes et utilisateurs
                    $q->where('materiels.fabricant', 'like', "%{$search}%")
                        ->orWhere('materiels.num_serie', 'like', "%{$search}%")
                        ->orWhere('imprimantes.identifiant_noir', 'like', "%{$search}%")
                        ->orWhere('imprimantes.identifiant_bleu', 'like', "%{$search}%")
                        ->orWhere('imprimantes.identifiant_magenta', 'like', "%{$search}%")
                        ->orWhere('imprimantes.identifiant_jaune', 'like', "%{$search}%")
                        ->orWhere('utilisateurs.nom', 'like', "%{$search}%")
                        ->orWhere('utilisateurs.email', 'like', "%{$search}%")
                        ->orWhere('affectations.statut', 'like', "%{$search}%");
                });
            })
            ->select(
                'materiels.id as materiel_id',
                'materiels.fabricant',
                'materiels.type',
                'materiels.num_serie',
                'materiels.etat',
                'imprimantes.identifiant_noir',
                'imprimantes.toner_noir',
                'imprimantes.identifiant_bleu',
                'imprimantes.toner_bleu',
                'imprimantes.identifiant_magenta',
                'imprimantes.toner_magenta',
                'imprimantes.identifiant_jaune',
                'imprimantes.toner_jaune',
                'imprimantes.ip_adresse',
                'affectations.statut',
                'utilisateurs.nom as utilisateur_nom',
            )
            ->orderBy('created_at', 'desc')
            ->get();
        $lastAffectations = Affectation::whereIn('materiel_id', $imprimantes->pluck('materiel_id'))
            ->whereIn('statut', ['AFFECTE', 'REAFFECTE'])
            ->orderByDesc('date_affectation')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('materiel_id');
        foreach ($imprimantes as $imprimante) {
            $last = $lastAffectations->get($imprimante->materiel_id)?->first();
            $imprimante->statut = $last ? $last->statut : 'NON AFFECTE';
        }
        return view('materiels.imprimantes.index', compact('imprimantes', 'search'));
    }

    public function create()
    {
        return view('materiels.imprimantes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'fabricant' => 'required|string|max:255',
            'num_serie' => 'required|string|max:255|unique:materiels,num_serie',
            'etat' => 'required|string|max:50',
            'identifiant_noir' => 'nullable|string|max:100',
            'toner_noir' => 'nullable|integer|min:0',
            'identifiant_bleu' => 'nullable|string|max:100',
            'toner_bleu' => 'nullable|integer|min:0',
            'identifiant_magenta' => 'nullable|string|max:100',
            'toner_magenta' => 'nullable|integer|min:0',
            'identifiant_jaune' => 'nullable|string|max:100',
            'toner_jaune' => 'nullable|integer|min:0',
            'ip_adresse' => 'nullable|string|max:45',
        ]);

        // Créer un nouvel enregistrement dans la table `materiels`
        $materiel = Materiel::create([
            'fabricant' => $request->fabricant,
            'num_serie' => $request->num_serie,
            'etat' => $request->etat,
            'type' => 'Imprimante', // Le type est toujours "IMPRIMANTE"
        ]);

        // Créer un nouvel enregistrement dans la table `imprimantes`
        Imprimante::create([
            'materiel_id' => $materiel->id, // Lier l'imprimante au matériel
            'identifiant_noir' => $request->identifiant_noir,
            'toner_noir' => $request->toner_noir,
            'identifiant_bleu' => $request->identifiant_bleu,
            'toner_bleu' => $request->toner_bleu,
            'identifiant_magenta' => $request->identifiant_magenta,
            'toner_magenta' => $request->toner_magenta,
            'identifiant_jaune' => $request->identifiant_jaune,
            'toner_jaune' => $request->toner_jaune,
            'ip_adresse' => $request->ip_adresse,
        ]);

        // Rediriger vers la liste des imprimantes avec un message de succès
        return redirect()->route('imprimantes.index')->with('message', 'Imprimante créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Imprimante $imprimante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($imprimante)
    {
        // Récupérer l'imprimante à modifier
        $imprimante = Materiel::where('type', 'IMPRIMANTE')
            ->join('imprimantes', 'materiels.id', '=', 'imprimantes.materiel_id')
            ->where('materiels.id', $imprimante)
            ->select(
                'materiels.id',
                'materiels.fabricant',
                'materiels.type',
                'materiels.num_serie',
                'materiels.etat',
                'imprimantes.identifiant_noir',
                'imprimantes.toner_noir',
                'imprimantes.identifiant_bleu',
                'imprimantes.toner_bleu',
                'imprimantes.identifiant_magenta',
                'imprimantes.toner_magenta',
                'imprimantes.identifiant_jaune',
                'imprimantes.toner_jaune',
                'imprimantes.ip_adresse'
            )
            ->firstOrFail(); // Si l'imprimante n'existe pas, renvoyer une erreur 404

        // Passer les données à la vue d'édition
        return view('materiels.imprimantes.edit', compact('imprimante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $imprimante)
    {
        // Valider les données du formulaire
        $request->validate([
            'fabricant' => 'required|string|max:255',
            'num_serie' => 'required|string|max:255|unique:materiels,num_serie,' . $imprimante,
            'etat' => 'required|string|max:50',
            'identifiant_noir' => 'nullable|string|max:100',
            'toner_noir' => 'nullable|integer|min:0',
            'identifiant_bleu' => 'nullable|string|max:100',
            'toner_bleu' => 'nullable|integer|min:0',
            'identifiant_magenta' => 'nullable|string|max:100',
            'toner_magenta' => 'nullable|integer|min:0',
            'identifiant_jaune' => 'nullable|string|max:100',
            'toner_jaune' => 'nullable|integer|min:0',
            'ip_adresse' => 'nullable|string|max:45',
        ]);

        // Récupérer l'imprimante à mettre à jour
        $materiel = Materiel::findOrFail($imprimante);
        $imprimante = Imprimante::where('materiel_id', $imprimante)->firstOrFail();

        // Mettre à jour les données dans la table `materiels`
        $materiel->update([
            'fabricant' => $request->fabricant,
            'num_serie' => $request->num_serie,
            'etat' => $request->etat,
        ]);

        // Mettre à jour les données dans la table `imprimantes`
        $imprimante->update([
            'identifiant_noir' => $request->identifiant_noir,
            'toner_noir' => $request->toner_noir,
            'identifiant_bleu' => $request->identifiant_bleu,
            'toner_bleu' => $request->toner_bleu,
            'identifiant_magenta' => $request->identifiant_magenta,
            'toner_magenta' => $request->toner_magenta,
            'identifiant_jaune' => $request->identifiant_jaune,
            'toner_jaune' => $request->toner_jaune,
            'ip_adresse' => $request->ip_adresse,
        ]);

        // Rediriger vers la liste des imprimantes avec un message de succès
        return redirect()->route('imprimantes.index')->with('message', 'Imprimante mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Récupérer le matériel correspondant à l'ID
        $materiel = Materiel::find($id);
        // Vérifier si l'imprimante a une affectation
        $affectation = Affectation::where('materiel_id', $id)->first();

        if ($affectation) {
            // Si le statut est AFFECTE ou REAFFECTE
            if (in_array($affectation->statut, ['AFFECTE', 'REAFFECTE'])) {
                return redirect()->back()
                    ->with('error', 'Ce matériel est actuellement affecté. Vous ne pouvez pas le supprimer.');
            }

            // Si le statut est NON AFFECTE
            if ($affectation->statut === 'NON AFFECTE') {
                // Supprimer l'affectation
                $affectation->delete();
                // Supprimer l'imprimante
                $imprimante = Imprimante::where('materiel_id', $materiel->id)->first();
                if ($imprimante) {
                    $imprimante->delete();
                }
                // Supprimer le matériel
                $materiel->delete();
                return redirect()->route('imprimantes.index')
                    ->with('message', 'Imprimante et l\'affectation associée supprimées avec succès.');
            }
        }

        // Si aucune affectation n'existe
        $imprimante = Imprimante::where('materiel_id', $materiel->id)->first();
        if ($imprimante) {
            $imprimante->delete();
        }
        $materiel->delete();
        return redirect()->route('imprimantes.index')
            ->with('message', 'Imprimante supprimée avec succès.');
    }
}
