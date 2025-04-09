@extends('layouts.app')

@section('title', 'Ajouter une imprimante')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-[#0A1C3E] px-6 py-4">
                    <h1 class="text-xl font-semibold text-white">Ajouter une imprimante</h1>
                </div>

                <form action="{{ route('imprimantes.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-8">
                        <!-- Section 1: Informations de base -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Informations de base</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                                    <input type="text" name="fabricant" value="{{ old('fabricant') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('fabricant') outline-2 outline-red-500 @enderror">
                                    @error('fabricant')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de Série</label>
                                    <input type="text" name="num_serie" value="{{ old('num_serie') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('num_serie') outline-2 outline-red-500 @enderror">
                                    @error('num_serie')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: État -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">État</h2>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">État</label>
                                <select name="etat" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('etat') outline-2 outline-red-500 @enderror">
                                    <option value="Neuf" {{ old('etat') == 'Neuf' ? 'selected' : '' }}>Neuf</option>
                                    <option value="Occasion" {{ old('etat') == 'Occasion' ? 'selected' : '' }}>Occasion
                                    </option>
                                    <option value="Endommagé" {{ old('etat') == 'Endommagé' ? 'selected' : '' }}>Endommagé
                                    </option>
                                </select>
                                @error('etat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 2.5: IP Adresse -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Adresse IP</h2>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse IP</label>
                                <input type="text" name="ip_adresse" value="{{ old('ip_adresse') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('ip_adresse') outline-2 outline-red-500 @enderror">
                                @error('ip_adresse')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 3: Toners -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Les toners</h2>
                            <div class="space-y-6">
                                <div class="grid grid-cols-5 items-center gap-3">
                                    <p class="text-sm font-medium text-gray-700">Couleur :</p>
                                    <p class="text-sm font-medium text-gray-700 text-center">Noir</p>
                                    <p class="text-sm font-medium text-gray-700 text-center">Bleu</p>
                                    <p class="text-sm font-medium text-gray-700 text-center">Magenta</p>
                                    <p class="text-sm font-medium text-gray-700 text-center">Jaune</p>
                                </div>

                                <div class="grid grid-cols-5 items-center gap-3">
                                    <p class="text-sm font-medium text-gray-700">Identifiant :</p>
                                    <div>
                                        <input type="text" name="identifiant_noir" value="{{ old('identifiant_noir') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E]">
                                    </div>
                                    <div>
                                        <input type="text" name="identifiant_bleu" value="{{ old('identifiant_bleu') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E]">
                                    </div>
                                    <div>
                                        <input type="text" name="identifiant_magenta"
                                            value="{{ old('identifiant_magenta') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E]">
                                    </div>
                                    <div>
                                        <input type="text" name="identifiant_jaune"
                                            value="{{ old('identifiant_jaune') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E]">
                                    </div>
                                </div>

                                <div class="grid grid-cols-5 items-center gap-3">
                                    <p class="text-sm font-medium text-gray-700">Quantité :</p>
                                    <div>
                                        <input type="number" min="0" name="toner_noir"
                                            value="{{ old('toner_noir') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E]">
                                    </div>
                                    <div>
                                        <input type="number" min="0" name="toner_bleu"
                                            value="{{ old('toner_bleu') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E]">
                                    </div>
                                    <div>
                                        <input type="number" min="0" name="toner_magenta"
                                            value="{{ old('toner_magenta') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E]">
                                    </div>
                                    <div>
                                        <input type="number" min="0" name="toner_jaune"
                                            value="{{ old('toner_jaune') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('imprimantes.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E]">
                            Annuler
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-[#0A1C3E] hover:bg-[#0A1C3E]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E]">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
