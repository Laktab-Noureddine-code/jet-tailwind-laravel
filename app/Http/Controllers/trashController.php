<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use Illuminate\Http\Request;

class trashController extends Controller
{
    public function index()
    {
        // Récupérer les affectations supprimées avec les relations utilisateur et matériel
        $affectations = Affectation::onlyTrashed()
            ->with(['utilisateur', 'materiel'])
            ->get();

        return view('trash.index', compact('affectations'));
    }

    public function forceDelete($id)
    {
        // Récupérer l'affectation supprimée
        $affectation = Affectation::onlyTrashed()->findOrFail($id);

        // Supprimer définitivement
        $affectation->forceDelete();

        return redirect()->route('trash.index')
            ->with('success', 'Affectation supprimée définitivement.');
    }
}
