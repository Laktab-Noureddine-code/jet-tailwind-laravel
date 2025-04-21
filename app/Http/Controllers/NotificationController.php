<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Imprimante;
use App\Models\Materiel;
use App\Models\Notification;
use App\Models\Ordinateur;
use App\Models\Telephone;
use App\Models\Type;
use App\Models\Utilisateur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Recrutement;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Notification::with('recrutement');

        // Recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('recrutement', function ($q) use ($search) {
                $q->where('nom', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('fonction', 'LIKE', "%$search%")
                    ->orWhere('departement', 'LIKE', "%$search%")
                    ->orWhere('telephone', 'LIKE', "%$search%")
                    ->orWhere('model', 'LIKE', "%$search%")
                    ->orWhere('type', 'LIKE', "%$search%")
                    ->orWhere('num_serie', 'LIKE', "%$search%")
                    ->orWhere('date_affectation', 'LIKE', "%$search%")
                    ->orWhere('type_contrat', 'LIKE', "%$search%")
                    ->orWhere('puk', 'LIKE', "%$search%")
                    ->orWhere('pin', 'LIKE', "%$search%")
                    ->orWhere('status', 'LIKE', "%$search%");
            });
        }

        // Ajouter pagination avec 20 éléments par page
        $notifications = $query->orderBy('is_read')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends(['search' => $request->search]);
        // dd($notifications);
        return view('notifications.index', compact('notifications'));
    }


    /**
     * Show the form for creating a new resource.
     */
    // public function valider(Notification $notification)
    // {
    //     // Récupérer le recrutement lié à cette notification
    //     $recrutement = $notification->recrutement;

    //     // Vérifier si le recrutement existe
    //     if (!$recrutement) {
    //         return redirect()->route('notifications.index')->with('error', 'Recrutement introuvable.');
    //     }
    //     $requiredFields = [
    //         'nom' => $recrutement->nom,
    //         'email' => $recrutement->email,
    //         'fonction' => $recrutement->fonction,
    //         'telephone' => $recrutement->telephone,
    //         'date_affectation' => $recrutement->date_affectation,
    //         'model' => $recrutement->model,
    //         'num_serie' => $recrutement->num_serie,
    //     ];

    //     foreach ($requiredFields as $field => $value) {
    //         if (empty($value)) {
    //             return redirect()->route('notifications.index')
    //                 ->with('error', "Le champ {$field} du recrutement est manquant.");
    //         }
    //     }
    //     $validator = Validator::make([
    //         'num_serie' => $recrutement->num_serie,
    //     ], [
    //         'num_serie' => 'required|unique:materiels,num_serie',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->route('notifications.index')
    //             ->with('error', 'Le numéro de série est déjà utilisé.');
    //     }

    //     // Mettre à jour le statut du recrutement à "validé"
    //     $recrutement->update(['status' => 'validé']);

    //     // Créer ou récupérer l'utilisateur
    //     $utilisateur = Utilisateur::firstOrCreate(
    //         ['email' => $recrutement->email],
    //         [
    //             'nom' => $recrutement->nom,
    //             'fonction' => $recrutement->fonction,
    //             'telephone' => $recrutement->telephone,
    //             'departement' => $recrutement->departement,
    //         ]
    //     );

    //     // Créer le matériel
    //     $materiel = Materiel::create([
    //         'fabricant' => $recrutement->model,
    //         'type' => $notification->type,
    //         'num_serie' => $recrutement->num_serie,
    //         'etat' => $notification->etat,
    //     ]);

    //     // Si le matériel est un téléphone, créer une entrée dans la table "telephones"
    //     if ($notification->type == 'Telephone') {
    //         Telephone::create([
    //             'pin' => $recrutement->pin,
    //             'puk' => $recrutement->puk,
    //             'materiel_id' => $materiel->id,
    //         ]);
    //     } elseif ($notification->type == 'PC Portable' || $notification->type == 'PC Bureau') {
    //         Ordinateur::create([
    //             'materiel_id' => $materiel->id,
    //         ]);
    //     } elseif ($notification->type == 'Imprimante') {
    //         Imprimante::create([
    //             'materiel_id' => $materiel->id,
    //         ]);
    //     }

    //     // Créer l'affectation
    //     Affectation::create([
    //         'materiel_id' => $materiel->id,
    //         'utilisateur_id' => $utilisateur->id,
    //         'date_affectation' => $recrutement->date_affectation,
    //         'chantier' => $notification->chantier,
    //         'statut' => 'AFFECTE',
    //         'utilisateur1' => $notification->utilisateur
    //     ]);

    //     // Marquer la notification comme lue
    //     $notification->update(['is_read' => true]);

    //     return redirect()->route('notifications.index')->with('success', 'Recrutement validé et matériel affecté.');
    // }

    public function valider(Notification $notification)
    {
        $recrutement = $notification->recrutement;

        if (!$recrutement) {
            return redirect()->route('notifications.index')->with('error', 'Recrutement introuvable.');
        }

        // Vérification des champs requis
        $requiredFields = [
            'nom' => $recrutement->nom,
            'email' => $recrutement->email,
            'fonction' => $recrutement->fonction,
            'telephone' => $recrutement->telephone,
            'date_affectation' => $recrutement->date_affectation,
            'num_serie' => $recrutement->num_serie,
        ];

        foreach ($requiredFields as $field => $value) {
            if (empty($value)) {
                return redirect()->route('notifications.index')
                    ->with('error', "Le champ {$field} du recrutement est manquant.");
            }
        }

        // Recherche du matériel par numéro de série
        $materiel = Materiel::where('num_serie', $recrutement->num_serie)->first();

        if (!$materiel) {
            // Si le matériel n'existe pas, on valide l'unicité
            $validator = Validator::make([
                'num_serie' => $recrutement->num_serie,
            ], [
                'num_serie' => 'required|unique:materiels,num_serie',
            ]);

            if ($validator->fails()) {
                return redirect()->route('notifications.index')
                    ->with('error', 'Le numéro de série est déjà utilisé.');
            }

            // Création du matériel
            $materiel = Materiel::create([
                'fabricant' => $recrutement->model,
                'type' => $notification->type,
                'num_serie' => $recrutement->num_serie,
                'etat' => $notification->etat,
            ]);
        }

        // Mettre à jour le statut du recrutement
        $recrutement->update(['status' => 'validé']);

        // Créer ou récupérer l'utilisateur
        $utilisateur = Utilisateur::firstOrCreate(
            ['email' => $recrutement->email],
            [
                'nom' => $recrutement->nom,
                'fonction' => $recrutement->fonction,
                'telephone' => $recrutement->telephone,
                'departement' => $recrutement->departement,
            ]
        );

        // Création spécifique selon type
        switch ($notification->type) {
            case 'Telephone':
                Telephone::firstOrCreate([
                    'materiel_id' => $materiel->id,
                ], [
                    'pin' => $recrutement->pin,
                    'puk' => $recrutement->puk,
                ]);
                break;
            case 'PC Portable':
            case 'PC Bureau':
                Ordinateur::firstOrCreate(['materiel_id' => $materiel->id]);
                break;
            case 'Imprimante':
                Imprimante::firstOrCreate(['materiel_id' => $materiel->id]);
                break;
        }

        // Vérifier la dernière affectation du matériel
        $lastAffectation = Affectation::where('materiel_id', $materiel->id)
            ->latest('date_affectation')
            ->first();

        if ($lastAffectation && in_array($lastAffectation->statut, ['AFFECTE', 'REAFFECTE'])) {
            // Mettre à jour l'ancienne affectation
            $lastAffectation->update(['statut' => 'NON AFFECTE']);
            $statut = 'REAFFECTE';
        } else {
            $statut = 'AFFECTE';
        }

        // Créer la nouvelle affectation
        Affectation::create([
            'materiel_id' => $materiel->id,
            'utilisateur_id' => $utilisateur->id,
            'date_affectation' => $recrutement->date_affectation,
            'chantier' => $notification->chantier,
            'statut' => $statut,
            'utilisateur1' => $notification->utilisateur
        ]);

        // Marquer la notification comme lue
        $notification->update(['is_read' => true]);

        return redirect()->route('notifications.index')->with('success', 'Recrutement validé et matériel affecté.');
    }




    public function edit(Notification $notification)
    {
        $typesMateriel = Type::select('type')
            ->orderByRaw("CASE WHEN type = 'Telephone' THEN 0 ELSE 1 END")
            ->pluck('type');
        return view('notifications.edit', compact('notification', 'typesMateriel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'fonction' => 'required|string|max:255',
            'type_contrat' => 'required',
            'date_affectation' => 'required',
            'telephone' => 'nullable|string',
            'fabricant' => 'nullable|string|max:255',
            'num_serie' => 'required',
            'type' => 'nullable|string',
            'etat' => 'nullable|in:Neuf,Occassion',
            'chantier' => 'max:255',
            'utilisateur' => 'max:255',
        ]);
        $materielExist = Materiel::where('num_serie', $request->num_serie)->exists();

        if (!$materielExist) {
            // Si nouveau numéro, vérifier les champs matériel
            if (empty($request->fabricant) || empty($request->type) || empty($request->etat)) {
                return back()->withInput()
                    ->with('error', 'Pour un nouveau numéro de série, les champs Modèle, Type et État sont obligatoires');
            }
        }

        // Mise à jour des informations du recrutement
        $notification->recrutement->update([
            'nom' => $request->nom,
            'email' => $request->email,
            'fonction' => $request->fonction,
            'type_contrat' => $request->type_contrat,
            'telephone' => $request->telephone,
            'model' => $request->fabricant, // Correspond au modèle du matériel
            'num_serie' => $request->num_serie,
            'date_affectation' => $request->date_affectation,
            'puk' => $request->puk,
            'pin' => $request->pin,
        ]);


        // Mise à jour des informations de la notification
        $notification->update([
            'type' => $request->type,
            'etat' => $request->etat,
            'chantier' => $request->chantier,
        ]);

        return redirect()->route('notifications.index')->with('success', 'Notification et recrutement mis à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        // Vérifier si le user est admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('notifications.index')->with('error', 'Vous n\'avez pas les permissions pour effectuer cette action.');
        }

        // Supprimer la notification
        $notification->delete();

        return redirect()->route('notifications.index')->with('success', 'Notification supprimée avec succès.');
    }
}
