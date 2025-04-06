@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Corbeille</h2>

        <!-- Tableau des affectations supprimées -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="max-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Utilisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matériel
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modéle
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            d'affectation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Utilisateur </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de
                            suppression</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($affectations as $affectation)
                        <tr>
                            <td class="px-6 py-4">
                                {{ $affectation->utilisateur->nom }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $affectation->materiel->type }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $affectation->materiel->fabricant }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $affectation->date_affectation }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $affectation->statut }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $affectation->chantier }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $affectation->utilisateur1 }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $affectation->deleted_at }}
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('trash.forceDelete', $affectation->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette affectation ?')"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Supprimer définitivement
                                    </button>
                                </form>
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
@endsection
