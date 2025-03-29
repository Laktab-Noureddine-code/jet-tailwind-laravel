@extends('layouts.app')
@section('title' ,'Imprimante')
@section('content')
    <div class="">
        <form action="{{route('imprimantes.store')}}" method="POST" class="form-container mt-2">
            @csrf
            <h1 class="header-title">Ajouter une imprimante</h1>

            <div class="grid grid-cols-2 gap-6">
                <!-- Fabricant -->
                <label class="form-label">Modèle
                    <input class="form-input mt-1" type="text" name="fabricant" 
                        value="{{ old('fabricant') }}" required>
                    @error('fabricant')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                
                <!-- État -->
                <label class="form-label">État
                    <select class="form-input mt-1" name="etat">
                        <option value="Neuf" {{ old('etat') == 'Neuf' ? 'selected' : '' }}>Neuf</option>
                        <option value="Occasion" {{ old('etat') == 'Occasion' ? 'selected' : '' }}>Occasion</option>
                    </select>
                    @error('etat')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
            </div>


            <!-- Numéro de Série -->
            <label class="form-label">Numéro de Série
                <input class="form-input mt-1" type="text" name="num_serie" 
                    value="{{ old('num_serie') }}" required>
                @error('num_serie')
                    <p class="error">{{ $message }}</p>
                @enderror
            </label>

            
            {{-- Toners --}}
            <h1 class="text-xl font-bold mt-3 underline">Les toners</h1>
            <div class="">
                <div class="grid grid-cols-5 items-center gap-3 ">
                    <p class="form-label my-4">Couleur :</p>
                    <p class="form-label text-center">Noir</p>
                    <p class="form-label text-center">Bleu</p>
                    <p class="form-label text-center">Magenta</p>
                    <p class="form-label text-center">Jaune</p>
                </div>
                <div class="grid grid-cols-5 items-center gap-3">
                    <p class="form-label my-4">Identifiant :</p>
                    <div>
                        <input type="text" value="{{ old('identifiant_noir') }}" name="identifiant_noir" class="form-input mt-1" >
                    </div>
                    <div>
                        <input type="text" value="{{ old('identifiant_bleu') }}" name="identifiant_bleu" class="form-input mt-1" >
                    </div>
                    <div>
                        <input type="text" value="{{ old('identifiant_magenta') }}" name="identifiant_magenta" class="form-input mt-1" >
                    </div>
                    <div>
                        <input type="text" value="{{ old('identifiant_jaune') }}" name="identifiant_jaune" class="form-input mt-1" >
                    </div>
                </div>
                <div class="grid grid-cols-5 items-center gap-3">
                    <p class="form-label my-4">Quantité :</p>

                    <div>
                        <input type="number" min="0" value="{{ old('toner_noir') }}" name="toner_noir" class="form-input mt-1" >
                    </div>
                    <div>
                        <input type="number" min="0" value="{{ old('toner_bleu') }}" name="toner_bleu" class="form-input mt-1" >
                    </div>
                    <div>
                        <input type="number" min="0" value="{{ old('toner_magenta') }}" name="toner_magenta" class="form-input mt-1" >
                    </div>
                    <div>
                        <input type="number" min="0" value="{{ old('toner_jaune') }}" name="toner_jaune" class="form-input mt-1" >
                    </div>
                </div>

            </div>

            <button type="submit" class="submitBtn">Enregistrer</button>
        </form>
    </div>
@endsection
