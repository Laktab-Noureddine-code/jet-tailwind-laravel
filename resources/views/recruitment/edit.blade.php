<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des Recrutements</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-gray-200">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow">
                <!-- Header -->
                <div class="bg-[#0A1C3E] px-6 py-4">
                    <h1 class="text-xl font-semibold text-white">Modifier le Recrutement</h1>
                </div>

                <form action="{{ route('recrutements.update', $recrutement) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Section 1: Informations personnelles -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Informations personnelles</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                    <input type="text" name="nom" value="{{ old('nom', $recrutement->nom) }}"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('nom') outline-2 outline-red-500 @enderror">
                                    @error('nom')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $recrutement->email) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('email') outline-2 outline-red-500 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Informations professionnelles -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Informations professionnelles
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fonction</label>
                                    <input type="text" name="fonction"
                                        value="{{ old('fonction', $recrutement->fonction) }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('fonction') outline-2 outline-red-500 @enderror">
                                    @error('fonction')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Departement</label>
                                    <input type="text" name="departement"
                                        value="{{ old('departement', $recrutement->departement) }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('departement') outline-2 outline-red-500 @enderror">
                                    @error('departement')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date
                                        d'affectation</label>
                                    <input type="date" name="date_affectation"
                                        value="{{ old('date_affectation', $recrutement->date_affectation) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('date_affectation') outline-2 outline-red-500 @enderror">
                                    @error('date_affectation')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Type de Contrat</label>
                                <div class="flex flex-wrap gap-4 mt-2">
                                    <label class="relative">
                                        <input type="radio" name="type_contrat" value="cdi"
                                            class="peer absolute opacity-0 w-0 h-0"
                                            {{ old('type_contrat', $recrutement->type_contrat) == 'cdi' ? 'checked' : '' }}>
                                        <span
                                            class="px-4 py-2 rounded-lg cursor-pointer block uppercase font-medium transition-all duration-200
                                            peer-checked:bg-[#0A1C3E] peer-checked:text-white
                                            bg-gray-100 text-gray-700 hover:bg-gray-200">
                                            CDI
                                        </span>
                                    </label>
                                    <label class="relative">
                                        <input type="radio" name="type_contrat" value="cdd"
                                            class="peer absolute opacity-0 w-0 h-0"
                                            {{ old('type_contrat', $recrutement->type_contrat) == 'cdd' ? 'checked' : '' }}>
                                        <span
                                            class="px-4 py-2 rounded-lg cursor-pointer block uppercase font-medium transition-all duration-200
                                            peer-checked:bg-[#0A1C3E] peer-checked:text-white
                                            bg-gray-100 text-gray-700 hover:bg-gray-200">
                                            CDD
                                        </span>
                                    </label>
                                    <label class="relative">
                                        <input type="radio" name="type_contrat" value="cp"
                                            class="peer absolute opacity-0 w-0 h-0"
                                            {{ old('type_contrat', $recrutement->type_contrat) == 'cp' ? 'checked' : '' }}>
                                        <span
                                            class="px-4 py-2 rounded-lg cursor-pointer block uppercase font-medium transition-all duration-200
                                            peer-checked:bg-[#0A1C3E] peer-checked:text-white
                                            bg-gray-100 text-gray-700 hover:bg-gray-200">
                                            CP
                                        </span>
                                    </label>
                                    <label class="relative">
                                        <input type="radio" name="type_contrat" value="interim"
                                            class="peer absolute opacity-0 w-0 h-0"
                                            {{ old('type_contrat', $recrutement->type_contrat) == 'interim' ? 'checked' : '' }}>
                                        <span
                                            class="px-4 py-2 rounded-lg cursor-pointer block font-medium transition-all duration-200
                                            peer-checked:bg-[#0A1C3E] peer-checked:text-white
                                            bg-gray-100 text-gray-700 hover:bg-gray-200">
                                            Interim
                                        </span>
                                    </label>
                                    <label class="relative">
                                        <input type="radio" name="type_contrat" value="autre"
                                            class="peer absolute opacity-0 w-0 h-0"
                                            {{ old('type_contrat', $recrutement->type_contrat) == 'autre' ? 'checked' : '' }}>
                                        <span
                                            class="px-4 py-2 rounded-lg cursor-pointer block font-medium transition-all duration-200
                                            peer-checked:bg-[#0A1C3E] peer-checked:text-white
                                            bg-gray-100 text-gray-700 hover:bg-gray-200">
                                            Autre
                                        </span>
                                    </label>
                                </div>
                                @error('type_contrat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 3: Informations techniques -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Informations téléphoniques</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                                    <input type="text" name="model"
                                        value="{{ old('model', $recrutement->model) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('model') outline-2 outline-red-500 @enderror">
                                    @error('model')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                    <input type="text" name="telephone"
                                        value="{{ old('telephone', $recrutement->telephone) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('telephone') outline-2 outline-red-500 @enderror">
                                    @error('telephone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de Série</label>
                                    <input type="text" name="num_serie"
                                        value="{{ old('num_serie', $recrutement->num_serie) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('num_serie') outline-2 outline-red-500 @enderror">
                                    @error('num_serie')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Informations de sécurité -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Informations de sécurité</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Puk</label>
                                    <input type="text" name="puk" value="{{ old('puk', $recrutement->puk) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('puk') outline-2 outline-red-500 @enderror">
                                    @error('puk')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pin</label>
                                    <input type="text" name="pin" value="{{ old('pin', $recrutement->pin) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('pin') outline-2 outline-red-500 @enderror">
                                    @error('pin')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('recrutements.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E]">
                            Annuler
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-[#0A1C3E] hover:bg-[#0A1C3E]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E]">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
