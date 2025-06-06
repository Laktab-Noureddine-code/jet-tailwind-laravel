@extends('layouts.app')

@section('title', 'Créer un Recrutement')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow">
                <!-- Header -->
                <div class="bg-[#0A1C3E] px-6 py-4">
                    <h1 class="text-xl font-semibold text-white">Ajouter un nouveau recrutement</h1>
                </div>

                <form action="{{ route('recrutements.store') }}" method="post" class="p-6">
                    @csrf

                    <div class="space-y-8">
                        <!-- Section 1: Informations personnelles -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Informations personnelles</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                    <input type="text" name="nom"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('nom') outline-2 outline-red-500 @enderror"
                                        value="{{ old('nom') }}" required>
                                    @error('nom')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('email') outline-2 outline-red-500 @enderror"
                                        value="{{ old('email') }}" required>
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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Chantier</label>
                                    <input type="text" name="chantier"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('chantier') outline-2 outline-red-500 @enderror"
                                        value="{{ old('chantier') }}" required>
                                    @error('chantier')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                 <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                    <input type="text" name="telephone"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('telephone') outline-2 outline-red-500 @enderror"
                                        value="{{ old('telephone') }}" required>
                                    @error('telephone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fonction</label>
                                    <input type="text" name="fonction"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('fonction') outline-2 outline-red-500 @enderror"
                                        value="{{ old('fonction') }}" required>
                                    @error('fonction')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Departement</label>
                                    <input type="text" name="departement"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('departement') outline-2 outline-red-500 @enderror"
                                        value="{{ old('departement') }}" required>
                                    @error('departement')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date
                                        d'affectation</label>
                                    <input type="date" name="date_affectation" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('date_affectation') outline-2 outline-red-500 @enderror"
                                        value="{{ old('date_affectation') }}">
                                    @error('date_affectation')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>



                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Type de Contrat</label>
                                    <div class="flex flex-wrap gap-4 mt-2">
                                        <label class="relative">
                                            <input type="radio" name="type_contrat" value="cdi"
                                                class="peer absolute opacity-0 w-0 h-0" checked
                                                {{ old('type_contrat') == 'cdi' ? 'checked' : '' }}>
                                            <span
                                                class="px-2 py-1 rounded-lg cursor-pointer block uppercase font-medium transition-all duration-200
                                                peer-checked:bg-[#0A1C3E] peer-checked:text-white
                                                bg-gray-100 text-gray-700 hover:bg-gray-200">
                                                CDI
                                            </span>
                                        </label>
                                        <label class="relative">
                                            <input type="radio" name="type_contrat" value="cdd"
                                                class="peer absolute opacity-0 w-0 h-0"
                                                {{ old('type_contrat') == 'cdd' ? 'checked' : '' }}>
                                            <span
                                                class="px-2 py-1 rounded-lg cursor-pointer block uppercase font-medium transition-all duration-200
                                                peer-checked:bg-[#0A1C3E] peer-checked:text-white
                                                bg-gray-100 text-gray-700 hover:bg-gray-200">
                                                CDD
                                            </span>
                                        </label>
                                        <label class="relative">
                                            <input type="radio" name="type_contrat" value="cp"
                                                class="peer absolute opacity-0 w-0 h-0"
                                                {{ old('type_contrat') == 'cp' ? 'checked' : '' }}>
                                            <span
                                                class="px-2 py-1 rounded-lg cursor-pointer block uppercase font-medium transition-all duration-200
                                                peer-checked:bg-[#0A1C3E] peer-checked:text-white
                                                bg-gray-100 text-gray-700 hover:bg-gray-200">
                                                CP
                                            </span>
                                        </label>
                                        <label class="relative">
                                            <input type="radio" name="type_contrat" value="interim"
                                                class="peer absolute opacity-0 w-0 h-0"
                                                {{ old('type_contrat') == 'interim' ? 'checked' : '' }}>
                                            <span
                                                class="px-2 py-1 rounded-lg cursor-pointer block font-medium transition-all duration-200
                                                peer-checked:bg-[#0A1C3E] peer-checked:text-white
                                                bg-gray-100 text-gray-700 hover:bg-gray-200">
                                                Interim
                                            </span>
                                        </label>
                                        <label class="relative">
                                            <input type="radio" name="type_contrat" value="autre"
                                                class="peer absolute opacity-0 w-0 h-0"
                                                {{ old('type_contrat') == 'autre' ? 'checked' : '' }}>
                                            <span
                                                class="px-2 py-1 rounded-lg cursor-pointer block font-medium transition-all duration-200
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
                        </div>

                        <!-- Section 3: Informations téléphoniques -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Informations téléphoniques</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                                    <input type="text" name="model"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('model') outline-2 outline-red-500 @enderror"
                                        value="{{ old('model') }}">
                                    @error('model')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de Série</label>
                                    <input type="text" name="num_serie"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('num_serie') outline-2 outline-red-500 @enderror"
                                        value="{{ old('num_serie') }}">
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
                                    <input type="text" name="puk"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('puk') outline-2 outline-red-500 @enderror"
                                        value="{{ old('puk') }}">
                                    @error('puk')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pin</label>
                                    <input type="text" name="pin"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('pin') outline-2 outline-red-500 @enderror"
                                        value="{{ old('pin') }}">
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
                            Ajouter le recrutement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
