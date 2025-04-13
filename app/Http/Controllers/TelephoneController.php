<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Telephone;
use Illuminate\Http\Request;



class TelephoneController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $telephones = Telephone::with(['materiel', 'materiel.affectations' => function ($query) {
            $query->latest('date_affectation')->take(1);
        }])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('pin', 'like', "%$search%")
                        ->orWhere('puk', 'like', "%$search%")
                        ->orWhereHas('materiel', function ($q) use ($search) {
                            $q->where('fabricant', 'like', "%$search%")
                                ->orWhere('num_serie', 'like', "%$search%")
                                ->orWhere('etat', 'like', "%$search%");
                        });
                });
            })
            ->paginate(15); // ou le nombre d'éléments par page que vous souhaitez

        return view('tel.index', compact('telephones', 'search'));
    }
    public function edit($id)
    {
        $telephone = Telephone::with('materiel')->findOrFail($id);
        return view('tel.edit', compact('telephone'));
    }
    public function update(Request $request, Telephone $telephone)
    {
        $request->validate([
            'pin' => 'string|max:255',
            'puk' => 'string|max:255',
            'fabricant' => 'required|string|max:255',
            'num_serie' => 'required|string|max:255|unique:materiels,num_serie,' . $telephone->materiel->id,
            'etat' => 'required|string|max:255',
        ]);

        // Mise à jour du téléphone
        $telephone->update([
            'pin' => $request->pin,
            'puk' => $request->puk,
        ]);
        // Mise à jour du matériel associé
        if ($telephone->materiel) {
            $telephone->materiel->update([
                'fabricant' => $request->fabricant,
                'num_serie' => $request->num_serie,
                'etat' => $request->etat,
            ]);
        }

        return redirect()->route('telephones.index')->with('success', 'Téléphone mis à jour avec succès.');
    }
    public function destroy($telephone)
    {
        // On récupère le téléphone par son ID
        $telephone = Telephone::findOrFail($telephone);

        // Vérifier si le téléphone a une affectation
        $affectation = Affectation::where('materiel_id', $telephone->materiel_id)->first();

        if ($affectation) {
            // Si le statut est AFFECTE ou REAFFECTE
            if (in_array($affectation->statut, ['AFFECTE', 'REAFFECTE'])) {
                return redirect()->back()
                    ->with('error', 'Ce téléphone est actuellement affecté. Vous ne pouvez pas le supprimer.');
            }
            
            // Si le statut est NON AFFECTE
            if ($affectation->statut === 'NON AFFECTE') {
                // Supprimer l'affectation
                $affectation->delete();
                // Supprimer le matériel associé
                if ($telephone->materiel) {
                    $telephone->materiel->delete();
                }
                // Supprimer le téléphone
                $telephone->delete();
                return redirect()->route('telephones.index')
                    ->with('success', 'Téléphone et l\'affectation associée supprimés avec succès.');
            }
        }

        // Si aucune affectation n'existe
        if ($telephone->materiel) {
            $telephone->materiel->delete();
        }
        $telephone->delete();
        return redirect()->route('telephones.index')
            ->with('success', 'Téléphone supprimé avec succès.');
    }
}
