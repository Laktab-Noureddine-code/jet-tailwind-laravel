<?php

namespace App\Http\Controllers;

use App\Models\BigAffectation;
use App\Http\Requests\StoreBigAffectationRequest;
use App\Http\Requests\UpdateBigAffectationRequest;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Unique;

class BigAffectationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBigAffectationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BigAffectation $bigAffectation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BigAffectation $bigAffectation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBigAffectationRequest $request, BigAffectation $bigAffectation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BigAffectation $bigAffectation)
    {
        //
    }

    /**
     * Upload a file for the big affectation
     */
    public function uploadFile(Request $request, BigAffectation $bigAffectation)
    {
        $request->validate([
            'fiche_affectations' => 'required|max:10240',
        ]);
        $utilisateurNom = Utilisateur::findOrFail($bigAffectation->utilisateur_id)->nom;
        // Delete old file if exists
        if ($bigAffectation->fiche_affectations) {
            Storage::disk('public')->delete($bigAffectation->fiche_affectations);
        }
        $file = $request->file('fiche_affectations');
        $uniqueName = $utilisateurNom . '.' . uniqid(true) . '.' . $file->getClientOriginalExtension();
        // Stocker le fichier avec le nouveau nom
        $path = $file->storeAs('fiche_affectations', $uniqueName, 'public');
        $bigAffectation->update(['fiche_affectations' => $path]);

        return back()->with('success', 'Fichier téléversé avec succès.');
    }
}
