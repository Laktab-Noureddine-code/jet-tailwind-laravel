@extends('layouts.app')

@section('title', 'ordinateur')

@section('content')
    <div class="container">
        <form action="{{ route('ordinateurs.store') }}" method="POST" class="form-container mt-10">
            @csrf
            <h1 class="header-title">Ajouter un ordinateur</h1>

            <!-- Fabricant -->
            <label class="form-label">Modèle
                <input class="form-input" type="text" name="fabricant" value="{{ old('fabricant') }}" required>
                @error('fabricant')
                    <p class="error">{{ $message }}</p>
                @enderror
            </label>

            <!-- Numéro de Série -->
            <label class="form-label">Numéro de Série
                <input class="form-input" type="text" name="num_serie" value="{{ old('num_serie') }}" required>
                @error('num_serie')
                    <p class="error">{{ $message }}</p>
                @enderror
            </label>

            <div class="grid grid-cols-2 gap-10">
                <!-- Type -->
                <label class="form-label">Type
                    <select class="form-input" name="type">
                        <option value="Pc Portable" {{ old('type') == 'Pc Portable' ? 'selected' : '' }}>Pc Portable</option>
                        <option value="Pc Bureau" {{ old('type') == 'Pc Bureau' ? 'selected' : '' }}>Pc Bureau</option>
                    </select>
                    @error('type')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                
                {{-- <!-- Statut -->
                <label class="form-label">Statut
                    <select class="form-input" name="statut">
                        <option value="NON AFFECTE" {{ old('statut') == 'NON AFFECTE' ? 'selected' : '' }}>NON AFFECTE</option>
                        <option value="AFFECTE" {{ old('statut') == 'AFFECTE' ? 'selected' : '' }}>AFFECTE</option>
                        <option value="REAFFECTE" {{ old('statut') == 'REAFFECTE' ? 'selected' : '' }}>RÉAFFECTE</option>
                    </select>
                    @error('statut')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label> --}}

                <!-- État -->
                <label class="form-label">État
                    <select class="form-input" name="etat">
                        <option value="Neuf" {{ old('etat') == 'Neuf' ? 'selected' : '' }}>Neuf</option>
                        <option value="Occasion" {{ old('etat') == 'Occasion' ? 'selected' : '' }}>Occasion</option>
                    </select>
                    @error('etat')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <!-- Processeur -->
                <label class="form-label">Processeur
                    <input class="form-input" type="text" name="processeur" value="{{ old('processeur') }}">
                    @error('processeur')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                <!-- RAM -->
                <label class="form-label">RAM
                    <input class="form-input" type="text" name="ram" value="{{ old('ram') }}">
                    @error('ram')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                <!-- Stockage -->
                <label class="form-label">Stockage
                    <input class="form-input" type="text" name="stockage" value="{{ old('stockage') }}">
                    @error('stockage')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
            </div>

            <button type="submit" class="submitBtn">Ajouter</button>
        </form>
    </div>
@endsection
