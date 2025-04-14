@extends('layouts.app')

@section('title', 'Gestion des Imprimantes')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Liste des Imprimantes</h1>
        </div>

        {{-- search & add component --}}
        <x-materiels.search-imprimante search="{{ $search }}" />

        <div class="mt-6 bg-white rounded-lg shadow">
            <div class="overflow-x-auto">
                <table class="w-full max-w-full text-left text-sm text-gray-500" id="materiels-table">
                    <thead class="text-xs uppercase text-white">
                        <tr class="bg-[#0A1C3E]">
                            <th scope="col" class="px-6 py-4">N° de Série</th>
                            <th scope="col" class="px-6 py-4">Modèle</th>
                            <th scope="col" class="px-6 py-4">Utilisateur</th>
                            <th scope="col" class="px-6 py-4">Statut</th>
                            <th scope="col" class="px-6 py-4">État</th>
                            <th scope="col" class="px-6 py-4">Toner Noir</th>
                            <th scope="col" class="px-6 py-4">Toner Bleu</th>
                            <th scope="col" class="px-6 py-4">Toner Magenta</th>
                            <th scope="col" class="px-6 py-4">Toner Jaune</th>
                            <th scope="col" class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($imprimantes as $imprimante)
                            <x-materiels.imprimantes-row :imprimante="$imprimante" />
                        @empty
                            <tr>
                                <td colspan="11" class="px-6 py-4 text-center text-gray-500">
                                    Aucune imprimante trouvée
                                </td>
                            </tr>
                        @endforelse
                        <tr class="js-no-results" style="display: none;">
                            <td colspan="11" class="px-6 py-4 text-center text-gray-500">
                                Aucune imprimante correspond au filtre
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
