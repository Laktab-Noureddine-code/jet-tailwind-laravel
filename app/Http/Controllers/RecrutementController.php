<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Recrutement;
use Illuminate\Http\Request;

class RecrutementController extends Controller
{
    public function index()
    {
        $recrutements = Recrutement::orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
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
            'type_contrat' => 'in:jet,total',
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
        $request->validate([
            'nom' => 'max:255',
            'email' => 'max:50',
            'type_contrat' => 'in:jet,total',
            'telephone' => 'max:20',
            'model' => 'max:255',
            'num_serie' => 'max:255',
            'puk' => 'max:255',
            'pin' => 'max:255',
        ]);

        $recrutement->update($request->only(['nom', 'email', 'type_contrat', 'telephone', 'model', 'num_serie', 'puk', 'pin']));

        return redirect()->route('recrutements.index')->with('success', 'Recrutement mis à jour avec succès.');
    }

    public function destroy(Recrutement $recrutement)
    {
        if ($recrutement->status === 'validé') {
            return redirect()->route('recrutements.index')->with('error', 'Impossible de supprimer un recrutement validé.');
        }
        $recrutement->delete();
        // Supprimer la notification associée
        if ($recrutement->notification) {
            $recrutement->notification->delete();
        }
        return redirect()->route('recrutements.index')->with('success', 'Recrutement supprimé avec succès.');
    }
}
