@extends('layouts.app')
@section('title' ,'peripherique')
@section('content')
    <div class="container">
        <form action="{{ route('peripheriques.store') }}" method="POST" class="form-container mt-10">
            @csrf
            <h1 class="header-title">Ajouter un nouveau périphérique</h1>

            <!-- Fabricant -->
            <label class="form-label">Modèle
                <input class="form-input" type="text" name="fabricant" 
                    value="{{ old('fabricant') }}" required>
                @error('fabricant')
                    <p class="error">{{ $message }}</p>
                @enderror
            </label>

            <!-- Numéro de Série -->
            <label class="form-label">Numéro de Série
                <input class="form-input" type="text" name="num_serie" 
                    value="{{ old('num_serie') }}" required>
                @error('num_serie')
                    <p class="error">{{ $message }}</p>
                @enderror
            </label>

            <div class="grid grid-cols-2 gap-10">
                <!-- Type -->
                <label class="form-label">Type
                    <select class="form-input" name="type" required>
                        @foreach ($types as $type)
                        <option value="{{$type}}" {{ old('type') == $type ? 'selected' : '' }}>{{$type}}</option>
                        @endforeach
                        {{-- <option value="Disque Externe" {{ old('type') == 'Disque Externe' ? 'selected' : '' }}>Disque Externe</option>
                        <option value="CLAVIER" {{ old('type') == 'CLAVIER' ? 'selected' : '' }}>Clavier</option>
                        <option value="ROUTEUR" {{ old('type') == 'ROUTEUR' ? 'selected' : '' }}>Routeur</option>
                        <option value="SOURIS" {{ old('type') == 'SOURIS' ? 'selected' : '' }}>Souris</option> --}}
                    </select>
                    @error('type')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>

                <!-- État -->
                <label class="form-label">État
                    <select class="form-input" name="etat" required>
                        <option value="Neuf" {{ old('etat') == 'Neuf' ? 'selected' : '' }}>Neuf</option>
                        <option value="Occasion" {{ old('etat') == 'Occasion' ? 'selected' : '' }}>Occasion</option>
                    </select>
                    @error('etat')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
            </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="submitBtn">Ajouter</button>
        </form>
    </div>
@endsection