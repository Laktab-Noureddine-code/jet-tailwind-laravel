<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('accounts.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Utilisateur ajouté avec succès');
    }

    public function edit(User $account)
    {
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, User $account)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $account->id,
            'password' => 'nullable|min:8',
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);

        // Vérifier si c'est le dernier admin qu'on essaie de changer en user
        if ($account->role === 'admin' && $request->role === 'user' && User::where('role', 'admin')->count() === 1) {
            return redirect()->route('accounts.index')
                ->with('error', 'Impossible de modifier le rôle du dernier administrateur.');
        }

        $account->name = $request->name;
        $account->email = $request->email;
        if ($request->filled('password')) {
            $account->password = Hash::make($request->password);
        }
        $account->role = $request->role;
        $account->save();

        return redirect()->route('accounts.index')
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function destroy($id)
    {
        Log::info('Tentative de suppression de l\'utilisateur ID: ' . $id);

        try {
            $user = User::findOrFail($id);

            Log::info('Utilisateur trouvé: ' . $user->email);

            // Vérifier si c'est le dernier admin
            if ($user->role === 'admin' && User::where('role', 'admin')->count() === 1) {
                Log::warning('Tentative de suppression du dernier admin');
                return redirect()->route('accounts.index')
                    ->with('error', 'Impossible de supprimer le dernier administrateur.');
            }

            $user->delete();
            Log::info('Utilisateur supprimé avec succès');

            return redirect()->route('accounts.index')
                ->with('success', 'Utilisateur supprimé avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression: ' . $e->getMessage());
            return redirect()->route('accounts.index')
                ->with('error', 'Erreur lors de la suppression de l\'utilisateur');
        }
    }
}
