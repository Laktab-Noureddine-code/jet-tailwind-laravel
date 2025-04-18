<?php

namespace App\Http\Controllers;

use App\Mail\MaterielsMail;
use App\Models\Affectation;
use App\Models\Materiel;
use App\Models\Ordinateur;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\BigAffectation;

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
            'fiche_affectation' => 'required|mimes:jpeg,png,jpg,pdf|max:6000',
        ]);

        try {
            // Vérifier si le fichier est bien téléchargé
            if (!$request->hasFile('fiche_affectation') || !$request->file('fiche_affectation')->isValid()) {
                return back()->with('error', 'Fichier invalide ou non téléchargé.');
            }

            // Générer un nom de fichier unique avec timestamp et id d'affectation
            $extension = $request->file('fiche_affectation')->getClientOriginalExtension();
            $utilisateur = $affectation->utilisateur;
            $uniqueCode = uniqid();
            $fileName = 'affectation_' . str_replace(' ', '_', $utilisateur->nom) . '_' . $uniqueCode . '.' . $extension;

            // Créer le répertoire s'il n'existe pas
            $storagePath = storage_path('app/public/affectations');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            // Stocker le fichier avec le nom personnalisé
            $path = $request->file('fiche_affectation')->storeAs('affectations', $fileName, 'public');

            // Vérifier si le chemin est vide
            if (empty($path)) {
                return back()->with('error', 'Impossible de sauvegarder le fichier. Veuillez réessayer.');
            }

            // Mettre à jour la base de données
            $affectation->update(['fiche_affectation' => $path]);

            return back()->with('success', 'Fiche affectation mise à jour avec succès !');
        } catch (\Exception $e) {
            // Log l'erreur
            error_log('Erreur lors du téléchargement : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du téléchargement : ' . $e->getMessage());
        }
    }

    /**
     * Alternative upload method that uses direct file system operations
     * Use this if the standard upload method isn't working on IIS
     */
    public function uploadDirect(Request $request, Affectation $affectation)
    {
        $request->validate([
            'fiche_affectation' => 'required|mimes:jpeg,png,jpg,pdf|max:6000',
        ]);

        try {
            // Vérifier si le fichier est bien téléchargé
            if (!$request->hasFile('fiche_affectation') || !$request->file('fiche_affectation')->isValid()) {
                return back()->with('error', 'Fichier invalide ou non téléchargé.');
            }

            // Générer un nom de fichier unique
            $extension = $request->file('fiche_affectation')->getClientOriginalExtension();
            $utilisateur = $affectation->utilisateur;
            $uniqueCode = uniqid();
            $fileName = 'affectation_' . str_replace(' ', '_', $utilisateur->nom) . '_' . $uniqueCode . '.' . $extension;

            // Créer le répertoire physique si nécessaire
            $uploadDirectory = public_path('uploads/affectations');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            // Déplacer directement le fichier
            $uploadedFile = $request->file('fiche_affectation');
            $filePath = $uploadDirectory . '/' . $fileName;

            if ($uploadedFile->move($uploadDirectory, $fileName)) {
                // Enregistrer le chemin relatif dans la base de données
                $relativePath = 'uploads/affectations/' . $fileName;
                $affectation->update(['fiche_affectation' => $relativePath]);

                return back()->with('success', 'Fiche affectation mise à jour avec succès !');
            } else {
                return back()->with('error', 'Impossible de déplacer le fichier.');
            }
        } catch (\Exception $e) {
            error_log('Erreur lors du téléchargement direct : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
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
        $materiel = Materiel::where('num_serie', $request->num_serie)->get()->first();
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
            'statut' => $statutAffectation,
            'materiel_id' => $request->id_materiel,
        ]);

        return redirect()->route('affectation.show', $utilisateur)->with('success', 'Affectation ajoutée avec succès.');
    }

    public function show($id)
    {
        // Retrieve the utilisateur with eager-loaded relationships
        $utilisateur = Utilisateur::with(['affectations.materiel', 'bigAffectations.bigAffectationRows.materiel'])->find($id);

        // Check if the utilisateur exists
        if (!$utilisateur) {
            return redirect()->route('affectation.index')->with('error', 'Utilisateur non trouvé.');
        }

        // Check if the utilisateur has no affectations or bigAffectations
        if ($utilisateur->affectations->isEmpty() && $utilisateur->bigAffectations->isEmpty()) {
            return redirect()->route('affectation.index')->with('error', 'Cet utilisateur n\'a aucune affectation.');
        }

        // If everything is fine, proceed to show the view
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

    public function sendEmail(Affectation $affectation)
    {
        try {
            Mail::to("nourd2008in@gmail.com")
                ->send(new TestMail($affectation));

            return back()->with('success', 'Email de confirmation envoyé avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }


    public function sendEmailMateriels(BigAffectation $bigAffectation)
    {
        try {
            // Load relationships
            $bigAffectation->load(['utilisateur', 'bigAffectationRows.materiel.affectations']);

            // Check if utilisateur exists
            if (!$bigAffectation->utilisateur) {
                return back()->with('error', 'Aucun utilisateur associé à cette affectation.');
            }

            // Check if there are any materiels
            if ($bigAffectation->bigAffectationRows->isEmpty()) {
                return back()->with('error', 'Aucun matériel associé à cette affectation.');
            }

            // Determine the chantier once (default to "Siege" if not available)
            $chantier = $bigAffectation->bigAffectationRows
                ->flatMap(function ($row) {
                    return $row->materiel->affectations;
                })
                ->first()?->chantier ?? "Siege";

            // Extract data for each material
            $data = [
                'utilisateur' => $bigAffectation->utilisateur,
                'chantier' => $chantier, // Single chantier for all materials
                'materiels' => $bigAffectation->bigAffectationRows->map(function ($row) use ($chantier) {
                    $materiel = $row->materiel;

                    return [
                        'materiel' => $materiel,
                        'date_affectation' => $materiel->affectations->first()?->date_affectation ?? now(),
                    ];
                }),
            ];

            // Debug the data (optional)
            // Send the email with the data
            Mail::to("nourd2008in@gmail.com")->send(new MaterielsMail($data));

            return back()->with('success', 'Email de confirmation envoyé avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
        }
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
    public function destroyInShow(Affectation $affectation)
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
        return redirect()->back()->with('message', "L'affectation a été supprimée avec succès.");
    }

    /**
     * Delete an uploaded file associated with an affectation
     */
    public function deleteFile(Affectation $affectation)
    {
        try {
            // Check if there's a file to delete
            if (!$affectation->fiche_affectation) {
                return back()->with('error', 'Aucun fichier à supprimer.');
            }

            // Determine the file path
            if (str_starts_with($affectation->fiche_affectation, 'uploads/')) {
                // Direct upload path
                $filePath = public_path($affectation->fiche_affectation);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            } else {
                // Laravel storage path
                Storage::disk('public')->delete($affectation->fiche_affectation);
            }

            // Clear the file path in the database
            $affectation->update(['fiche_affectation' => null]);

            return back()->with('success', 'Fichier supprimé avec succès.');
        } catch (\Exception $e) {
            error_log('Erreur lors de la suppression du fichier : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression du fichier: ' . $e->getMessage());
        }
    }

    /**
     * Securely download a file associated with an affectation.
     * This works on all devices by streaming the file directly from PHP.
     */
    public function downloadFile(Affectation $affectation)
    {
        try {
            // Check if a file exists
            if (!$affectation->fiche_affectation) {
                return back()->with('error', 'Aucun fichier disponible pour téléchargement.');
            }

            // Determine the file path
            if (str_starts_with($affectation->fiche_affectation, 'uploads/')) {
                // Direct upload path
                $filePath = public_path($affectation->fiche_affectation);
            } else {
                // Laravel storage path
                $filePath = storage_path('app/public/' . $affectation->fiche_affectation);
            }

            // Verify the file exists
            if (!file_exists($filePath)) {
                return back()->with('error', 'Le fichier est introuvable.');
            }

            // Get the file info
            $fileInfo = pathinfo($filePath);
            $fileName = $fileInfo['basename'];
            $extension = $fileInfo['extension'];

            // Map file extension to MIME type
            $mimeTypes = [
                'pdf' => 'application/pdf',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                // Add more as needed
            ];

            $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

            // Stream the file directly from PHP
            return response()->file($filePath, [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
        } catch (\Exception $e) {
            error_log('Erreur lors du téléchargement du fichier : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du téléchargement du fichier: ' . $e->getMessage());
        }
    }
}
