<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Http\Requests\StoreMaterielRequest;
use App\Http\Requests\UpdateMaterielRequest;
use Illuminate\Http\Request;

class MaterielController extends Controller
{
    public function index(){
        return view('dashboard.index');
    }
    public function checkSerie($num_serie)
    {
        $materiel = Materiel::where('num_serie', $num_serie)->first();

        return response()->json([
            'exists' => $materiel ? true : false,
            'materiel' => $materiel
        ]);
    }
}
