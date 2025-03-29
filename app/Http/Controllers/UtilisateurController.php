<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Http\Requests\StoreUtilisateurRequest;
use App\Http\Requests\UpdateUtilisateurRequest;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
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
    public function store(StoreUtilisateurRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données du formulaire
        $request->validate([
            'email' => 'required|email|unique:utilisateurs,email,' . $id,
            'telephone' => 'string|max:20',
            'departement' => 'string|max:100',
            'fonction' => 'string|max:100',
        ]);

        // Récupérer l'utilisateur à modifier
        $utilisateur = Utilisateur::findOrFail($id);

        // Mettre à jour les informations
        $utilisateur->update([
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'departement' => $request->departement,
            'fonction' => $request->fonction
        ]);

        // Redirection avec un message de succès
        return redirect()->back()->with('message', 'Utilisateur mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Utilisateur $utilisateur)
    {
        //
    }
}
