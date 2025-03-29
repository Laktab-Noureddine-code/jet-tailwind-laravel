<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            'name'=>'required|string',
            'email' => 'required|email|unique:users,email,' . $account->id,
            'password' => 'nullable|min:8',
        ]);

        if ($request->email) {
            $account->email = $request->email;
        }

        if ($request->password) {
            $account->password = Hash::make($request->password);
        }
        if ($request->name) {
            $account->name = $request->name;
        }
        $account->role = $request->role;

        $account->save();

        return redirect()->route('accounts.index')->with('success', 'Utilisateur mis à jour avec succès');
    }


    public function destroy(User $user)
    {
        // $use = User::find($user->id);
        // dd($use);
        // Vérifier si c'est le seul admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() === 1) {
            return redirect()->route('accounts.index')->with('error', 'Impossible de supprimer le dernier administrateur.');
        }
        $user->delete();
        return redirect()->route('accounts.index')->with('success', 'Utilisateur supprimé');
    }
}
