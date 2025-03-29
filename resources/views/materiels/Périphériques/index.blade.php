@extends('layouts.app')

@section('title', 'peripherique')

@section('content')
    <div class="">
        @if (session('message'))
            <p class="message">{{ session('message') }}</p>
        @endif

        {{-- Titre de la page --}}
        <h1 class="header-title my-2">Liste des Périphériques</h1>

        {{-- Composant de recherche et d'ajout --}}
        <x-materiels.search-p search="{{ $search }}" />

        @if (session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif
        {{-- Tableau des périphériques --}}
        <table class="table" id="materiels-table">
            <thead>
                <tr class="tr">
                    <th class="pl-2">Modèle</th>
                    <th class="pl-2">Type</th>
                    <th class="pl-2">Statut</th>
                    <th class="pl-2">Numéro de Série</th>
                    <th class="pl-2">État</th>
                    <th class="pl-2" colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peripheriques as $peripherique)
                    <x-materiels.p-row :peripherique="$peripherique" />
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">Aucun périphérique trouvé.</td>
                    </tr>
                @endforelse
                <tr class="js-no-results" style="display: none;">
                    <td colspan="10 " class=" text-center text-gray-500 py-4">Aucun ordinateur correspond au filtre</td>
                </tr>
            </tbody>
        </table>

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
