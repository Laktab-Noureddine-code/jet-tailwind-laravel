<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
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
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'type' => 'required|string|max:255|unique:types,type',
        ]);

        // Création du type
        Type::create(['type' => $request->type]);

        // Redirection avec message
        return redirect()->back()->with('success', 'Type ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $typeInMateriel = Materiel::where('type', $id)->exists();
        if ($typeInMateriel) {
            return redirect()->back()->with(['error' => 'Impossible de supprimer le type ' . $id . ' car il est encore utilisé.']);
        }
        $type = Type::where('type', $id)->select('id')->first();
        Type::destroy($type->id);
        return redirect()->back()->with(['error' => 'Type supprimé avec succès.']);
    }
}
