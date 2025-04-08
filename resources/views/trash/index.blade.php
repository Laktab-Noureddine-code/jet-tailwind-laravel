@extends('layouts.app')

@section('title', 'Gestion de la Corbeille')

@section('content')
    <div class="container mx-auto">
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 px-6 py-5 text-base text-green-700" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Corbeille</h1>
        </div>

        <div class="mt-6 bg-white rounded-lg shadow">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500">
                    <thead class="text-xs uppercase text-white">
                        <tr class="bg-[#0A1C3E]">
                            <th scope="col" class="px-6 py-4">Utilisateur</th>
                            <th scope="col" class="px-6 py-4">Matériel</th>
                            <th scope="col" class="px-6 py-4">Numéro de série</th>
                            <th scope="col" class="px-6 py-4">Date d'affectation</th>
                            <th scope="col" class="px-6 py-4">Statut</th>
                            <th scope="col" class="px-6 py-4">Chantier</th>
                            <th scope="col" class="px-6 py-4">Utilisateur</th>
                            <th scope="col" class="px-6 py-4">Date de suppression</th>
                            <th scope="col" class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($affectations as $affectation)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if ($affectation->utilisateur && $affectation->utilisateur->exists)
                                        {{ $affectation->utilisateur->nom ?? 'N/A' }}
                                    @else
                                        <span class="text-gray-400">Utilisateur supprimé</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($affectation->materiel && $affectation->materiel->exists)
                                        {{ $affectation->materiel->type ?? 'N/A' }}
                                    @else
                                        <span class="text-gray-400">Matériel supprimé</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($affectation->materiel && $affectation->materiel->exists)
                                        {{ $affectation->materiel->num_serie ?? 'N/A' }}
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $affectation->date_affectation ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $affectation->statut ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $affectation->chantier ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $affectation->utilisateur1 ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $affectation->deleted_at ? $affectation->deleted_at->format('Y-m-d H:i:s') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <form action="{{ route('trash.forceDelete', $affectation->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette affectation ?')"
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                                    Aucune affectation supprimée trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
