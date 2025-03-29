@extends('layouts.app')

@section('title', 'Imprimante')

@section('content')
    <div class="">
        @if (session('message'))
            <p class="message">{{ session('message') }}</p>
        @endif

        <h1 class="header-title my-2">Liste des Imprimantes</h1>
        <x-materiels.search-imprimante search="{{ $search }}" />
        {{-- Tableau des imprimantes --}}
        <table class="table" id="materiels-table">
            <thead>
                <tr class="tr">
                    <th class="pl-2">Modèle</th>
                    <th class="pl-2">Numéro de Série</th>
                    <th class="pl-2">Utilisateur</th>
                    <th class="pl-2">Statut</th>
                    <th class="pl-2">État</th>
                    <th class="pl-2 bg-black">Noir</th>
                    <th class="pl-2 bg-blue-400">Bleu</th>
                    <th class="pl-2 bg-red-500">Magenta</th>
                    <th class="pl-2 bg-[#ffff00] text-black">Jaune</th>
                    <th class="pl-2" colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($imprimantes as $imprimante)
                    <tr>
                        <x-materiels.imprimantes-row :imprimante="$imprimante" />
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center">Aucune imprimante trouvée.</td>
                    </tr>
                @endforelse
                <tr class="js-no-results" style="display: none;">
                    <td colspan="10 " class=" text-center text-gray-500 py-4">Aucun ordinateur correspond au filtre</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-5">
            {{ $imprimantes->links() }}
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
