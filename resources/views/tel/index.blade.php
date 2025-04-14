@extends('layouts.app')

@section('title', 'Gestion des Téléphones')

@section('content')
    <div class="container mx-auto">

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 px-6 py-5 text-base text-green-700" role="alert">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 px-6 py-5 text-base text-red-700" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Liste des Téléphones</h1>
        </div>

        {{-- search component --}}
        <x-materiels.search-tel search="{{ $search }}" />

        <div class="mt-6 bg-white shadow">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500" id="materiels-table">
                    <thead class="text-xs uppercase text-white">
                        <tr class="bg-[#0A1C3E]">
                            <th scope="col" class="px-6 py-4">Modèle</th>
                            <th scope="col" class="px-6 py-4">Numéro de Série</th>
                            <th scope="col" class="px-6 py-4">État</th>
                            <th scope="col" class="px-6 py-4">Statut</th>
                            <th scope="col" class="px-6 py-4">Utilisateur</th>
                            <th scope="col" class="px-6 py-4">PIN</th>
                            <th scope="col" class="px-6 py-4">PUK</th>
                            <th scope="col" class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($telephones as $telephone)
                            <tr class="border-b hover:bg-gray-50"
                                data-statut="{{ $telephone->materiel->affectations->isNotEmpty() ? $telephone->materiel->affectations->first()->statut : 'NON AFFECTE' }}">
                                <td class="px-6 py-4">{{ $telephone->materiel->fabricant }}</td>
                                <td class="px-6 py-4">{{ $telephone->materiel->num_serie }}</td>
                                <td class="px-6 py-4">{{ $telephone->materiel->etat }}</td>
                                <td class="px-6 py-4">
                                    @if ($telephone->materiel->affectations->isNotEmpty())
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                            {{ $telephone->materiel->affectations->first()->statut }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                            NON AFFECTÉ
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($telephone->materiel->affectations->isNotEmpty() && $telephone->materiel->affectations->first()->utilisateur)
                                        {{ $telephone->materiel->affectations->first()->utilisateur->nom }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $telephone->pin }}</td>
                                <td class="px-6 py-4">{{ $telephone->puk }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('telephones.edit', $telephone->id) }}"
                                            class="text-blue-600 hover:text-blue-900">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('telephones.destroy', $telephone->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Supprimer ce téléphone ?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    Aucun téléphone trouvé.
                                </td>
                            </tr>
                        @endforelse
                        <tr class="js-no-results" style="display: none;">
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                Aucun téléphone correspond au filtre
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('input[name="statut"]').change(function() {
                const selectedStatut = $(this).val();
                let hasVisibleRows = false;

                // Filtrer les lignes
                $('#materiels-table tbody tr[data-statut]').each(function() {
                    const rowStatut = $(this).data('statut');
                    const isVisible = (selectedStatut === 'all' || rowStatut === selectedStatut);

                    $(this).toggle(isVisible);
                    if (isVisible) hasVisibleRows = true;
                });

                // Gérer le message
                $('.js-no-results').toggle(!hasVisibleRows);

                // Masquer le message initial si besoin
                $('.no-results').toggle(!hasVisibleRows && selectedStatut === 'all');
            });
        });
    </script>
@endsection
