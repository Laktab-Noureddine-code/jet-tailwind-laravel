@extends('layouts.app')

@section('title', 'Modifier le téléphone')

@section('content')
    <div>
        <h1 class="header-title">Modifier le téléphone</h1>

        <form action="{{ route('telephones.update', $telephone) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-2">
                <div class="form-group">
                    <label class="form-label" for="fabricant">Model</label>
                    <input class="form-input" type="text" name="fabricant" id="fabricant"
                        value="{{ old('fabricant', $telephone->materiel->fabricant) }}" required>
                    @error('fabricant')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">État du Matériel</label>
                    <select name="etat" class="form-input" required>
                        <option value="Neuf" {{ $telephone->materiel->etat == 'Neuf' ? 'selected' : '' }}>Neuf</option>
                        <option value="Occassion" {{ $telephone->materiel->etat == 'Occassion' ? 'selected' : '' }}>
                            Occassion
                        </option>
                    </select>
                    @error('etat')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="num_serie">Numéro de série</label>
                <input class="form-input" type="text" name="num_serie" id="num_serie"
                    value="{{ old('num_serie', $telephone->materiel->num_serie) }}" required>
                @error('num_serie')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div class="form-group">
                    <label class="form-label" for="pin">PIN</label>
                    <input class="form-input" type="text" name="pin" id="pin"
                        value="{{ old('pin', $telephone->pin) }}">
                    @error('pin')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="puk">PUK</label>
                    <input class="form-input" type="text" name="puk" id="puk"
                        value="{{ old('puk', $telephone->puk) }}">
                    @error('puk')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit"
                class="w-full text-center bg-gray-700 text-white font-bold py-2 mt-15 cursor-pointer  rounded-lg">Enregistrer</button>
        </form>
    </div>
@endsection
