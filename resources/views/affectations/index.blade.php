@extends('layouts.app')
@section('title', 'Gestion des Affectations')
@section('content')
    <div class="container mx-auto">
        @if (session('message'))
            <div class="mb-4 rounded-lg bg-green-100 px-6 py-5 text-base text-green-700" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Liste des Affectations</h1>
        </div>

        {{-- search & add component --}}
        <x-affectations.search-affectation search="{{ $search }}" />

        <div class="mt-6 bg-white rounded-lg shadow">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500">
                    <thead class="text-xs uppercase text-white">
                        <tr class="bg-[#0A1C3E]">
                            <th class="px-2 py-2">Nom</th>
                            <th class="px-2 py-2">Email</th>
                            <th class="px-2 py-2">Date d'Affectation</th>
                            <th class="px-8 py-2">Modèle</th>
                            <th class="px-2 py-2">Type</th>
                            <th class="px-2 py-2">Statut</th>
                            <th class="px-2 py-2">Numéro de Série</th>
                            <th class="px-2 py-2">État</th>
                            <th class="px-2 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($affectations as $affectation)
                            <x-affectations.affectation-row :affectation="$affectation" />
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                                    Aucune affectation trouvée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $affectations->links() }}
            </div>
        </div>
    </div>
@endsection
