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
}
