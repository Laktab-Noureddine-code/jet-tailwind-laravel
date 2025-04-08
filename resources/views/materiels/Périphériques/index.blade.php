@extends('layouts.app')

@section('title', 'Gestion des Périphériques')

@section('content')
    <div class="container mx-auto">
        @if (session('message'))
            <div class="mb-4 rounded-lg bg-green-100 px-6 py-5 text-base text-green-700" role="alert">
                {{ session('message') }}

            </div>
        @endif


        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 px-6 py-5 text-base text-red-700" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Liste des Périphériques</h1>
        </div>

        {{-- search & add component --}}
        <x-materiels.search-p search="{{ $search }}" />

        <div class="mt-6 bg-white rounded-lg shadow">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500" id="materiels-table">
                    <thead class="text-xs uppercase text-white">
                        <tr class="bg-[#0A1C3E]">
                            <th scope="col" class="px-6 py-4">Numéro de Série</th>
                            <th scope="col" class="px-6 py-4">Modèle</th>
                            <th scope="col" class="px-6 py-4">Type</th>
                            <th scope="col" class="px-6 py-4">Statut</th>
                            <th scope="col" class="px-6 py-4">État</th>
                            <th scope="col" class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peripheriques as $peripherique)
                            <x-materiels.p-row :peripherique="$peripherique" />
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Aucun périphérique trouvé
                                </td>
                            </tr>
                        @endforelse
                        <tr class="js-no-results" style="display: none;">
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Aucun périphérique correspond au filtre
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-5">
            {{ $peripheriques->links() }}
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
