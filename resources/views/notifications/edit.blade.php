@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="header-title my-2">Modifier le Recrutement</h1>
        <form action="{{ route('notifications.update', $notification->id) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            {{-- informations d'utilisateur --}}
            <div class="grid grid-cols-2 gap-2">
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-input" name="nom" value="{{ $notification->recrutement->nom }}">
                    @error('nom')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" name="email" value="{{ $notification->recrutement->email }}">
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="mb-3">
                    <label class="form-label">Fonction</label>
                    <input type="text" class="form-input" name="fonction"
                        value="{{ $notification->recrutement->fonction }}">
                    @error('fonction')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">departement</label>
                    <input type="text" name="departement"
                        value="{{ old('departement', $notification->recrutement->departement) }}" class="form-input"
                        required>
                    @error('departement')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Type de Contrat</label>
                <input type="radio" {{ $notification->recrutement->type_contrat == 'jet' ? 'checked' : '' }} checked
                    name="type_contrat" value="jet"> Jet
                <input type="radio" {{ $notification->recrutement->type_contrat == 'total' ? 'checked' : '' }}
                    name="type_contrat" value="total"> Total
                @error('type_contrat')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Informations du Matériel --}}
            <div class="grid grid-cols-3 gap-2">
                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" class="form-input" name="telephone"
                        value="{{ $notification->recrutement->telephone }}">
                    @error('telephone')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Modèle</label>
                    <input type="text" class="form-input" name="fabricant"
                        value="{{ $notification->recrutement->model }}">
                    @error('fabricant')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Numéro de Série</label>
                    <input type="text" class="form-input" name="num_serie"
                        value="{{ $notification->recrutement->num_serie }}">
                    @error('num_serie')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div class="mb-3">
                    <label class="form-label">Type de Matériel</label>
                    <select name="type" class="form-input" required>
                        @foreach ($typesMateriel as $type)
                            <option value="{{ $type }}" {{ $notification->type == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">État du Matériel</label>
                    <select name="etat" class="form-input" required>
                        <option value="Neuf" {{ $notification->etat == 'Neuf' ? 'selected' : '' }}>Neuf</option>
                        <option value="Occassion" {{ $notification->etat == 'Occassion' ? 'selected' : '' }}>Occassion
                        </option>
                    </select>
                    @error('etat')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div class="mb-3">
                    <label class="form-label">Puk</label>
                    <input type="text" name="puk" value="{{ old('puk', $notification->recrutement->puk) }}"
                        class="form-input">
                    @error('puk')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Pin</label>
                    <input type="text" name="pin" value="{{ old('pin', $notification->recrutement->pin) }}"
                        class="form-input">
                    @error('pin')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>


            {{-- Informations de l'Affectation --}}
            <div class="grid grid-cols-3 gap-2">
                <div class="mb-3">
                    <label class="form-label">Date d'Affectation</label>
                    <input type="date" name="date_affectation" class="form-input"
                        value="{{ $notification->date_affectation }}">
                    @error('date_affectation')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Chantier</label>
                    <input type="text" name="chantier" class="form-input" value="{{ $notification->chantier }}">
                    @error('chantier')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Utilisateur</label>
                    <input type="text" name="utilisateur" class="form-input"
                        value="{{ $notification->utilisateur }}">
                    @error('utilisateur')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="w-full text-center bg-gray-700 text-white font-bold py-2 mt-2 cursor-pointer  rounded-lg">Modifier</button>

        </form>
    </div>
@endsection
