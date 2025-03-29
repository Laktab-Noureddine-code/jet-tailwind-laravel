<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-[#f6f7f9]">
    <div class="">
        <h1 class="text-center text-3xl font-bold p-3">Modifier le Recrutement</h1>

        <form action="{{ route('recrutements.update', $recrutement) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-2">
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom', $recrutement->nom) }}" class="form-input" required>
                    @error('nom')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $recrutement->email) }}"class="form-input">
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="mb-3">
                    <label class="form-label">Fonction</label>
                    <input type="text" name="fonction" value="{{ old('fonction', $recrutement->fonction) }}"
                        class="form-input" required>
                    @error('fonction')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">departement</label>
                    <input type="text" name="departement" value="{{ old('departement', $recrutement->departement) }}"
                        class="form-input" required>
                    @error('departement')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Type de Contrat</label>
                <input type="radio" {{ $recrutement->type_contrat == 'jet' ? 'checked' : '' }} checked name="type_contrat"
                    value="jet"> Jet
                <input type="radio" {{ $recrutement->type_contrat == 'total' ? 'checked' : '' }} name="type_contrat"
                    value="total"> Total
                @error('type_contrat')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $recrutement->telephone) }}"
                        class="form-input">
                    @error('telephone')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Modèle</label>
                    <input type="text" name="model" value="{{ old('model', $recrutement->model) }}" class="form-input">
                    @error('model')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Numéro de Série</label>
                    <input type="text" name="num_serie" value="{{ old('num_serie', $recrutement->num_serie) }}"
                        class="form-input">
                    @error('num_serie')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="mb-3">
                    <label class="form-label">Puk</label>
                    <input type="text" name="puk" value="{{ old('puk', $recrutement->puk) }}" class="form-input">
                    @error('puk')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Pin</label>
                    <input type="text" name="pin" value="{{ old('pin', $recrutement->pin) }}" class="form-input">
                    @error('pin')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="w-full text-center bg-gray-700 text-white font-bold py-2 mt-2 cursor-pointer  rounded-lg">Modifier</button>
        </form>
    </div>
</body>
</html>
