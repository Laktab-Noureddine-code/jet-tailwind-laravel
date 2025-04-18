<?php

namespace App\Http\Controllers;

use App\Models\BigAffectation;
use App\Http\Requests\StoreBigAffectationRequest;
use App\Http\Requests\UpdateBigAffectationRequest;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Log;

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
        // Validation des données
        $request->validate([
            'fiche_affectations' => 'required|mimes:jpeg,png,jpg,pdf|max:10240',
        ]);

        try {
            // Vérifier si le fichier est bien téléchargé
            if (!$request->hasFile('fiche_affectations') || !$request->file('fiche_affectations')->isValid()) {
                return back()->with('error', 'Fichier invalide ou non téléchargé.');
            }

            // Récupérer le nom de l'utilisateur
            $utilisateurNom = Utilisateur::findOrFail($bigAffectation->utilisateur_id)->nom;

            // Supprimer l'ancien fichier s'il existe
            if ($bigAffectation->fiche_affectations) {
                Storage::disk('public')->delete($bigAffectation->fiche_affectations);
            }

            // Récupérer le fichier téléchargé
            $file = $request->file('fiche_affectations');

            // Générer un nom de fichier unique
            $extension = $file->getClientOriginalExtension();
            $uniqueCode = uniqid(true); // Use `true` for more randomness
            $fileName = 'affectation_' . str_replace(' ', '_', $utilisateurNom) . '_' . $uniqueCode . '.' . $extension;

            // Définir le chemin de stockage
            $storagePath = storage_path('app/public/fiche_affectations');

            // Créer le répertoire s'il n'existe pas
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            // Debugging: Log the file and path details
            Log::info('File Info:', ['file' => $file, 'realPath' => $file->getRealPath()]);
            Log::info('Generated File Name:', ['fileName' => $fileName]);
            Log::info('Storage Path:', ['storagePath' => $storagePath]);

            // Stocker le fichier avec le nouveau nom
            $path = $file->storeAs('fiche_affectations', $fileName, 'public');

            // Vérifier si le chemin est vide
            if (empty($path)) {
                Log::error('Empty path returned by storeAs():', ['fileName' => $fileName]);
                return back()->with('error', 'Impossible de sauvegarder le fichier. Veuillez réessayer.');
            }

            // Mettre à jour la base de données
            $bigAffectation->update(['fiche_affectations' => $path]);

            return back()->with('success', 'Fichier téléversé avec succès.');
        } catch (\Exception $e) {
            // Log l'erreur
            Log::error('Erreur lors du téléchargement : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du téléchargement : ' . $e->getMessage());
        }
    }
}
