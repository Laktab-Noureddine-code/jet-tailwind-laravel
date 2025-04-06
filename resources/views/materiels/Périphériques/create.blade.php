@extends('layouts.app')

@section('title', 'Ajouter un périphérique')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-[#0A1C3E] px-6 py-4">
                    <h1 class="text-xl font-semibold text-white">Ajouter un nouveau périphérique</h1>
                </div>

                <form action="{{ route('peripheriques.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="space-y-8">
                        <!-- Section 1: Informations de base -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Informations de base</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                                    <input type="text" name="fabricant" value="{{ old('fabricant') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('fabricant') outline-1 outline-red-500 @enderror">
                                    @error('fabricant')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de Série</label>
                                    <input type="text" name="num_serie" value="{{ old('num_serie') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('num_serie') outline-1 outline-red-500 @enderror">
                                    @error('num_serie')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Type et État -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Caractéristiques</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                    <select name="type" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('type') outline-1 outline-red-500 @enderror">
                                        @foreach ($types as $type)
                                            <option value="{{ $type }}"
                                                {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">État</label>
                                    <select name="etat" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('etat') outline-1 outline-red-500 @enderror">
                                        <option value="Neuf" {{ old('etat') == 'Neuf' ? 'selected' : '' }}>Neuf</option>
                                        <option value="Occasion" {{ old('etat') == 'Occasion' ? 'selected' : '' }}>Occasion
                                        </option>
                                        <option value="Endommagé" {{ old('etat') == 'Endommagé' ? 'selected' : '' }}>
                                            Endommagé</option>
                                    </select>
                                    @error('etat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('peripheriques.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E]">
                            Annuler
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-[#0A1C3E] hover:bg-[#0A1C3E]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E]">
                            Ajouter le périphérique
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
