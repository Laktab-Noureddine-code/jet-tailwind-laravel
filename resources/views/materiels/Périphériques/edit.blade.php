@extends('layouts.app')
@section('title' ,'peripherique')
@section('content')
    <div class="container">
        <form action="{{ route('peripheriques.update', $peripherique->id) }}" method="POST" class="form-container mt-10">
            @csrf
            @method('PUT')
            <h1 class="header-title">Modifier le périphérique</h1>

            <!-- Fabricant -->
            <label class="form-label">Modèle
                <input class="form-input" type="text" name="fabricant" 
                    value="{{ old('fabricant', $peripherique->fabricant) }}" required>
                @error('fabricant')
                    <p class="error">{{ $message }}</p>
                @enderror
            </label>

            <!-- Numéro de Série -->
            <label class="form-label">Numéro de Série
                <input class="form-input" type="text" name="num_serie" 
                    value="{{ old('num_serie', $peripherique->num_serie) }}" required>
                @error('num_serie')
                    <p class="error">{{ $message }}</p>
                @enderror
            </label>

            <div class="grid grid-cols-2 gap-10">
                <!-- Type -->
                <label class="form-label">Type
                    <select class="form-input" name="type">
                        @foreach ($types as $type)
                        <option value="{{$type}}" {{ old('type', $peripherique->type) == $type ? 'selected' : '' }}>{{$type}}</option>
                        @endforeach
                        {{-- <option value="ROUTEUR" {{ old('type', $peripherique->type) == 'ROUTEUR' ? 'selected' : '' }}>Routeur</option>
                        <option value="SOURIS" {{ old('type', $peripherique->type) == 'SOURIS' ? 'selected' : '' }}>Souris</option>
                        <option value="Disque Externe" {{ old('type', $peripherique->type) == 'Disque Externe' ? 'selected' : '' }}>Disque Externe</option> --}}
                    </select>
                    @error('type')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                
                
                <!-- État -->
                <label class="form-label">État
                    <select class="form-input" name="etat">
                        <option value="Neuf" {{ old('etat', $peripherique->etat) == 'Neuf' ? 'selected' : '' }}>Neuf</option>
                        <option value="Occasion" {{ old('etat', $peripherique->etat) == 'Occasion' ? 'selected' : '' }}>Occasion</option>
                        <option value="Endommagé" {{ old('etat', $peripherique->etat) == 'Endommagé' ? 'selected' : '' }}>Endommagé</option>
                    </select>
                    @error('etat')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
            </div>

            <button type="submit" class="submitBtn">Enregistrer</button>
        </form>
    </div>
@endsection