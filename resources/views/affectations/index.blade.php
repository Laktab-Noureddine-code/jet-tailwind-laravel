@extends('layouts.app')
@section('title', 'affectations')
@section('content')
    <div class="">
        @if (session('message'))
            <p class="message">{{ session('message') }}</p>
        @endif

        <h1 class="header-title my-2">Liste des Affectations</h1>
        {{-- search & add component --}}
        <x-affectations.search-affectation search="{{ $search }}" />
        <table class="table">
            <thead>
                <tr class="tr">
                    <th class="pl-2">Nom</th>
                    <th class="pl-2">Email</th>
                    <th class="pl-2">Date d'Affectation</th>
                    <th class="pl-2">Modèle</th>
                    <th class="pl-2">Type</th>
                    <th class="pl-2">Statut</th>
                    <th class="pl-2">Numéro de Série</th>
                    <th class="pl-2">État</th>
                    <th class="pl-2" colspan="4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($affectations as $affectation)
                    <x-affectations.affectation-row :affectation="$affectation" />
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-500 py-4">Aucun affectation trouvé.</td>
                    </tr>
                @endforelse 
            </tbody>
            </table>
            <div class="mt-5">
                {{ $affectations->links() }}
            </div>
        </div>
    @endsection
