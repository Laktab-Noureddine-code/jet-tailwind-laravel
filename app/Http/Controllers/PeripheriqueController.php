<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use Illuminate\Http\Request;
use App\Models\Materiel;
use App\Models\Type;

class PeripheriqueController extends Controller
{
    /**
     * Afficher la liste des périphériques.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');


        // Types exclus (à externaliser en config si utilisé souvent)
        $excludedTypes = ['PC Bureau', 'PC Portable', 'Imprimante', 'Telephone'];

        // Requête de base pour les périphériques
        $peripheriques = Materiel::with(['affectations' => function ($query) {
            $query->latest('date_affectation')->take(1);
        }])
            ->whereNotIn('type', $excludedTypes)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('fabricant', 'like', "%$search%")
                        ->orWhere('num_serie', 'like', "%$search%")
                        ->orWhere('etat', 'like', "%$search%")
                        ->orWhere('type', 'like', "%$search%");
                });
            })
            ->paginate(25);

        // Ajout du statut à chaque matériel
        $peripheriques->each(function ($materiel) {
            $materiel->statut = $materiel->affectations->first()->statut ?? 'NON AFFECTE';
        });

        return view('materiels.périphériques.index', compact('peripheriques', 'search'));
    }


    /**
     * Afficher le formulaire de création d'un périphérique.
     */
    public function create()
    {
        $types = Type::all()->select('type')->pluck('type');
        return view('materiels.périphériques.create', compact('types'));
    }

    /**
     * Enregistrer un nouveau périphérique.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'fabricant' => 'required|string|max:255',
            'type' => 'required|string',
            'num_serie' => 'required|string|max:255|unique:materiels,num_serie',
            'etat' => 'required|string|max:50',
        ]);

        // Créer un nouveau périphérique dans la table `materiels`
        Materiel::create([
            'fabricant' => $request->fabricant,
            'type' => $request->type,
            'num_serie' => $request->num_serie,
            'etat' => $request->etat,
        ]);

        // Rediriger vers la liste des périphériques avec un message de succès
        return redirect()->route('peripheriques.index')->with('message', 'Périphérique créé avec succès.');
    }

    /**
     * Afficher les détails d'un périphérique.
     */
    public function show($id)
    {
        // Récupérer le périphérique
        // $peripherique = Materiel::findOrFail($id);

        // // Passer les données à la vue
        // return view('materiels.peripheriques.show', compact('peripherique'));
    }

    /**
     * Afficher le formulaire d'édition d'un périphérique.
     */
    public function edit($id)
    {
        // Récupérer le périphérique à modifier
        $peripherique = Materiel::findOrFail($id);
        $types = Type::all()->select('type')->pluck('type');

        // Passer les données à la vue
        return view('materiels.périphériques.edit', compact('peripherique', 'types'));
    }

    /**
     * Mettre à jour un périphérique.
     */
    public function update(Request $request, $id)
    {
        // Valider les données du formulaire
        $request->validate([
            'fabricant' => 'required|string|max:255',
            'type' => 'required|string',
            'num_serie' => 'required|string|max:255|unique:materiels,num_serie,' . $id,
            'etat' => 'required|string|max:50',
        ]);

        // Récupérer le périphérique à mettre à jour
        $peripherique = Materiel::findOrFail($id);

        // Mettre à jour les données dans la table `materiels`
        $peripherique->update([
            'fabricant' => $request->fabricant,
            'type' => $request->type,
            'num_serie' => $request->num_serie,
            'etat' => $request->etat,
        ]);

        // Rediriger vers la liste des périphériques avec un message de succès
        return redirect()->route('peripheriques.index')->with('message', 'Périphérique mis à jour avec succès.');
    }

    /**
     * Supprimer un périphérique.
     */
    public function destroy($id)
    {
        // Récupérer le périphérique à supprimer
        $peripherique = Materiel::findOrFail($id);

        // Vérifier si le périphérique a une affectation
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
                // Supprimer le périphérique
                $peripherique->delete();
                return redirect()->route('peripheriques.index')
                    ->with('message', 'Périphérique et l\'affectation associée supprimés avec succès.');
            }
        }

        // Si aucune affectation n'existe
        $peripherique->delete();
        return redirect()->route('peripheriques.index')
            ->with('message', 'Périphérique supprimé avec succès.');
    }
}
