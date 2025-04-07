<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Utilisateur;
use App\Models\Materiel;
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

        // Vérifier si les relations existent encore
        foreach ($affectations as $affectation) {
            if ($affectation->utilisateur_id && !Utilisateur::withTrashed()->find($affectation->utilisateur_id)) {
                $affectation->utilisateur = null;
            }
            if ($affectation->materiel_id && !Materiel::withTrashed()->find($affectation->materiel_id)) {
                $affectation->materiel = null;
            }
        }

        return view('trash.index', compact('affectations'));
    }

    public function forceDelete($id)
    {
        // Récupérer l'affectation supprimée
        $affectation = Affectation::onlyTrashed()->findOrFail($id);

        // Supprimer définitivement
        $affectation->forceDelete();

        return redirect()->route('trash.index')
            ->with('success', 'L\'affectation a été supprimée définitivement.');
    }
}
