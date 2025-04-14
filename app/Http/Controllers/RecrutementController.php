<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Recrutement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecrutementController extends Controller
{
    public function index(Request $request)
    {
        $query = Recrutement::query();
        // Recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('fonction', 'LIKE', "%$search%")
                    ->orWhere('departement', 'LIKE', "%$search%")
                    ->orWhere('telephone', 'LIKE', "%$search%")
                    ->orWhere('model', 'LIKE', "%$search%")
                    ->orWhere('num_serie', 'LIKE', "%$search%")
                    ->orWhere('date_affectation', 'LIKE', "%$search%")
                    ->orWhere('type_contrat', 'LIKE', "%$search%")
                    ->orWhere('puk', 'LIKE', "%$search%")
                    ->orWhere('pin', 'LIKE', "%$search%")
                    ->orWhere('status', 'LIKE', "%$search%");
            });
        }

        // Ajouter pagination avec 20 éléments par page
        $recrutements = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends(['search' => $request->search]);

        return view('recruitment.index', compact('recrutements'));
    }

    public function create()
    {
        return view('recruitment.create');
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'max:40',
            'fonction' => 'required',
            'departement' => 'required',
            'date_affectation' => 'required',
            'type_contrat' => 'required',
            'telephone' => 'max:20',
            'model' => 'max:255',
            'num_serie' => 'unique:materiels,num_serie',
            'puk' => 'max:255',
            'pin' => 'max:255',
        ]);
        $recrutement = Recrutement::create($fields);
        Notification::create([
            'recrutement_id' => $recrutement->id,
            'is_read' => false,
        ]);

        return redirect()->route('recrutements.index')->with('success', 'Recrutement créé avec succès.');
    }

    public function edit(Recrutement $recrutement)
    {
        if ($recrutement->status === 'validé') {
            return redirect()->route('recrutements.index')->with('error', 'Impossible de modifier un recrutement validé.');
        }
        return view('recruitment.edit', compact('recrutement'));
    }

    public function update(Request $request, Recrutement $recrutement)
    {
        // dd($request);
        $fields = $request->validate([
            'nom' => 'max:255',
            'email' => 'max:50',
            'type_contrat' => 'required',
            'telephone' => 'max:20',
            'model' => 'max:255',
            'date_affectation' => 'required',
            'num_serie' => 'max:255',
            'puk' => 'max:255',
            'pin' => 'max:255',
        ]);

        $recrutement->update($fields);

        return redirect()->route('recrutements.index')->with('success', 'Recrutement mis à jour avec succès.');
    }

    public function destroy(Recrutement $recrutement)
    {
        // Vérifie si l'utilisateur est admin
        if (Auth::user()->role === 'admin') {
            // Supprimer la notification associée
            if ($recrutement->notification) {
                $recrutement->notification->delete();
            }
            // Supprimer le recrutement
            $recrutement->delete();

            return redirect()->route('recrutements.index')->with('success', 'Recrutement supprimé avec succès.');
        }

        // Si ce n'est pas un admin et que le recrutement est validé, empêcher la suppression
        if ($recrutement->status === 'validé') {
            return redirect()->route('recrutements.index')->with('error', 'Impossible de supprimer un recrutement validé.');
        }

        // Cas standard pour non-admin avec recrutement non validé
        $recrutement->delete();

        // Supprimer la notification associée
        if ($recrutement->notification) {
            $recrutement->notification->delete();
        }

        return redirect()->route('recrutements.index')->with('success', 'Recrutement supprimé avec succès.');
    }
}
