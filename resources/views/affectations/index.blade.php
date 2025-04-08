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
                            <th scope="col" class="px-6 py-4">Nom</th>
                            <th scope="col" class="px-6 py-4">Email</th>
                            <th scope="col" class="px-6 py-4">Date d'Affectation</th>
                            <th scope="col" class="px-6 py-4">Modèle</th>
                            <th scope="col" class="px-6 py-4">Type</th>
                            <th scope="col" class="px-6 py-4">Statut</th>
                            <th scope="col" class="px-6 py-4">Numéro de Série</th>
                            <th scope="col" class="px-6 py-4">État</th>
                            <th scope="col" class="px-6 py-4 text-center">Actions</th>
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
