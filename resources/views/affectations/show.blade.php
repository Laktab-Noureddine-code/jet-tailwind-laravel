@extends('layouts.app')

@section('title', 'Affectation')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- User Information Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                <!-- Header -->
                <div class="bg-[#0A1C3E] px-6 py-4">
                    <h1 class="text-xl font-semibold text-white">Informations de l'utilisateur</h1>
                </div>

                <form action="{{ route('utilisateur.update', $utilisateur->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Name -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Informations Personnelles</h2>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom & Prénom</label>
                                <input type="text" name="nom" value="{{ $utilisateur->nom }}" disabled
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $utilisateur->email) }}"
                                        disabled
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Téléphone -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                    <input type="text" name="telephone"
                                        value="{{ old('telephone', $utilisateur->telephone) }}" disabled
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                    @error('telephone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Département -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                                    <input type="text" name="departement"
                                        value="{{ old('departement', $utilisateur->departement) }}" disabled
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                    @error('departement')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Fonction -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fonction</label>
                                    <input type="text" name="fonction"
                                        value="{{ old('fonction', $utilisateur->fonction) }}" disabled
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                    @error('fonction')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="button" id="edit-btn"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E]">
                            <i class="fas fa-edit mr-2"></i>Modifier
                        </button>
                        <button type="submit" id="save-btn"
                            class="hidden px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-[#0A1C3E] hover:bg-[#0A1C3E]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E]">
                            <i class="fa-solid fa-floppy-disk mr-2"></i>Enregistrer
                        </button>
                        <button type="button" id="cancel-btn"
                            class="hidden px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E]">
                            <i class="fa-solid fa-xmark mr-2"></i>Annuler
                        </button>
                    </div>
                </form>
            </div>

            <!-- Affectations List Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-[#0A1C3E] px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-white">Liste des affectations</h2>
                    <div>
                        <button id="toggle-selection"
                            class="px-3 py-1 text-sm font-medium text-white bg-gray-500 rounded hover:bg-gray-600">
                            <i class="fa-solid fa-check-square mr-1"></i>Sélection multiple
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <form id="multi-materiel-form" action="{{ route('generateBigAffectation') }}" method="POST"
                        class="hidden mb-4">
                        @csrf
                        <input type="hidden" name="utilisateur_id" value="{{ $utilisateur->id }}">
                        <div class="flex justify-end space-x-2">
                            <button type="button" id="select-all"
                                class="px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600">
                                <i class="fa-solid fa-check-double mr-1"></i>Tout sélectionner
                            </button>
                            <button type="button" id="deselect-all"
                                class="px-3 py-1 text-sm font-medium text-white bg-gray-500 rounded hover:bg-gray-600">
                                <i class="fa-solid fa-ban mr-1"></i>Désélectionner tout
                            </button>
                            <button type="submit"
                                class="px-3 py-1 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700">
                                Générer
                            </button>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th id="selection-column"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden">
                                        Sélection
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Modèle</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Numéro de série</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date d'affectation</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Utilisateur</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($utilisateur->affectations as $affectation)
                                    <tr class="hover:bg-gray-50">
                                        <td
                                            class="px-6 py-4  text-sm text-gray-900 selection-checkbox hidden">
                                            <input type="checkbox" name="selected_materiels[]" form="multi-materiel-form"
                                                value="{{ $affectation->materiel_id }}"
                                                class="materiel-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                        </td>
                                        <td class="px-6 py-4  text-sm text-gray-900">
                                            @if ($affectation->materiel)
                                                {{ $affectation->materiel->fabricant }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4  text-sm text-gray-900">
                                            @if ($affectation->materiel)
                                                {{ $affectation->materiel->type }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4  text-sm text-gray-900">
                                            @if ($affectation->materiel)
                                                {{ $affectation->materiel->num_serie }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4  text-sm text-gray-900">
                                            {{ $affectation->date_affectation }}
                                        </td>
                                        <td class="px-6 py-4  text-sm text-gray-900">
                                            {{ $affectation->utilisateur1 }}</td>
                                        <td class="px-6 py-4  text-sm text-gray-900">
                                            {{ $affectation->statut }}</td>
                                        <td class="px-6 py-4  text-sm text-gray-900">
                                            <div class="flex items-center space-x-4">
                                                <form action="{{ route('destroyInShow', $affectation) }}" method="post"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette affectation')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('generatePdf', $affectation) }}"
                                                    title="Voir la fiche d'affectation"
                                                    class="text-red-700 hover:text-red-900">
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                </a>
                                                <form action="{{ route('send.affectation.email', $affectation) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir envoyer un email de confirmation ?')"
                                                        title="Envoyer email de confirmation"
                                                        class="text-blue-500 hover:text-blue-700 cursor-pointer">
                                                        <i class="fa-solid fa-envelope"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('upload.direct', $affectation) }}" method="POST"
                                                    enctype="multipart/form-data" class="inline">
                                                    @csrf
                                                    @method('POST')
                                                    <label for="fiche_{{ $affectation->id }}"
                                                        title="Ajouter une fiche d'affectation"
                                                        class="cursor-pointer text-gray-500 hover:text-gray-700">
                                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                                    </label>
                                                    <input type="file" name="fiche_affectation"
                                                        id="fiche_{{ $affectation->id }}" class="hidden"
                                                        onchange="document.getElementById('save_{{ $affectation->id }}').classList.remove('hidden')">
                                                    <button type="submit" id="save_{{ $affectation->id }}"
                                                        class="hidden ml-2 px-2 py-1 text-xs font-medium text-white bg-[#0A1C3E] rounded-md hover:bg-[#0A1C3E]/90">
                                                        Enregistrer
                                                    </button>
                                                </form>
                                                @if ($affectation->fiche_affectation)
                                                    @php
                                                        $filePath = str_starts_with(
                                                            $affectation->fiche_affectation,
                                                            'uploads/',
                                                        )
                                                            ? $affectation->fiche_affectation
                                                            : 'storage/' . $affectation->fiche_affectation;
                                                    @endphp
                                                    <a href="{{ route('download.file', $affectation) }}"
                                                        title="télécharger la fiche d'affectation"
                                                        class="text-gray-600 hover:text-gray-800">
                                                        <i class="fa-solid fa-file"></i>
                                                    </a>
                                                    <form action="{{ route('delete.file', $affectation) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fichier ? Cette action est irréversible.')"
                                                            title="Supprimer le fichier d'affectation"
                                                            class="text-red-500 hover:text-red-700 cursor-pointer">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('userExists', $utilisateur->id) }}"
                            class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-[#0A1C3E] hover:bg-[#0A1C3E]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E]">
                            Ajouter une affectation
                        </a>
                    </div>
                </div>
            </div>

            <!-- Big Affectations List Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mt-8">
                <!-- Header -->
                <div class="bg-[#0A1C3E] px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">Affectation matériel multiples</h2>
                </div>

                <div class="p-6">
                    @if ($utilisateur->bigAffectations && $utilisateur->bigAffectations->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach ($utilisateur->bigAffectations as $bigAffectation)
                                <div
                                    class="bg-gray-200 rounded-lg border border-gray-300 shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <!-- Header avec la liste des matériels -->
                                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                                        <div class="space-y-2">
                                            @foreach ($bigAffectation->bigAffectationRows as $row)
                                                <div class="flex justify-between items-center text-sm">
                                                    <span
                                                        class="font-medium text-gray-700">{{ $row->materiel->fabricant }}</span>
                                                    <span class="text-gray-500 bg-gray-100 px-2 py-1 rounded-full text-xs">
                                                        {{ $row->materiel->num_serie }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        @if ($bigAffectation->fiche_affectations)
                                            <a href="{{ Storage::url($bigAffectation->fiche_affectations) }}" download
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">
                                                <i class="fas fa-download mr-2"></i>
                                                Télécharger le fichier
                                            </a>
                                        @else
                                            <div class="text-center text-gray-500 py-4">
                                                Aucun fichier associé.
                                            </div>
                                        @endif
                                    </div>


                                    <!-- Footer avec les boutons -->
                                    <div class="p-4 bg-gray-50">
                                        <div class="flex space-x-2 items-center justify-between">
                                            <!-- Bouton Upload -->
                                            <div class="flex items-center gap-3">
                                                <form action="{{ route('upload.big.file', $bigAffectation) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <label for="file_{{ $bigAffectation->id }}"
                                                        class="text-gray-600 hover:bg-gray-100 rounded-full transition-colors duration-200 cursor-pointer"
                                                        title="Téléverser un fichier">
                                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                                    </label>
                                                    <input type="file" id="file_{{ $bigAffectation->id }}"
                                                        name="fiche_affectations" class="hidden"
                                                        onchange="this.form.submit()">
                                                </form>
                                                <form action="{{ route('generateMultiPdf') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" value="{{ $bigAffectation->id }}"
                                                        name="bigAffectation">
                                                    <button title="Voir la fiche d'affectations"
                                                        class="text-red-700 hover:text-red-900">
                                                        <i class="fa-solid fa-file-pdf"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('send.affectations.email', $bigAffectation) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir envoyer un email de confirmation ?')"
                                                        title="Envoyer email de confirmation"
                                                        class="text-blue-500 hover:text-blue-700 cursor-pointer">
                                                        <i class="fa-solid fa-envelope"></i>
                                                    </button>
                                                </form>
                                            </div>


                                            <!-- Bouton Supprimer -->
                                            <form action="{{ route('delete.big.affectation', $bigAffectation) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette affectation multiple ? Cette action supprimera également toutes les données associées.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors duration-200"
                                                    title="Supprimer l'affectation multiple">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <i class="fas fa-box-open text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-600">Aucune affectation multiple</h3>
                            <p class="text-gray-500 mt-2">Sélectionnez plusieurs matériels et cliquez sur "Générer"
                                pour créer une affectation multiple</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#edit-btn").click(function() {
                // Activer les champs du formulaire
                $("input").prop("disabled", false);
                $("input").addClass('focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] bg-white');

                // Masquer le bouton Modifier et afficher Enregistrer + Annuler
                $("#edit-btn").hide();
                $("#save-btn, #cancel-btn").removeClass("hidden");
            });

            $("#cancel-btn").click(function() {
                // Réinitialiser les champs avec les valeurs d'origine
                $("input").each(function() {
                    $(this).val($(this)[0].defaultValue);
                });
                // Désactiver les champs du formulaire
                $("input").prop("disabled", true);
                $("input").removeClass('focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] bg-white')
                    .addClass('bg-gray-50');

                // Réafficher Modifier et cacher Enregistrer + Annuler
                $("#edit-btn").show();
                $("#save-btn, #cancel-btn").addClass("hidden");
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const toggleSelectionBtn = document.getElementById('toggle-selection');
            const multiMaterielForm = document.getElementById('multi-materiel-form');
            const selectionCheckboxes = document.querySelectorAll('.selection-checkbox');
            const selectionColumn = document.getElementById('selection-column');
            const selectAllBtn = document.getElementById('select-all');
            const materielCheckboxes = document.querySelectorAll('.materiel-checkbox');

            // Toggle selection mode
            toggleSelectionBtn.addEventListener('click', function() {
                multiMaterielForm.classList.toggle('hidden');
                selectionColumn.classList.toggle('hidden');

                selectionCheckboxes.forEach(checkbox => {
                    checkbox.classList.toggle('hidden');
                });

                if (multiMaterielForm.classList.contains('hidden')) {
                    toggleSelectionBtn.innerHTML =
                        '<i class="fa-solid fa-check-square mr-1"></i>Sélection multiple';
                    toggleSelectionBtn.classList.remove('bg-gray-500');
                    toggleSelectionBtn.classList.add('bg-gray-500');
                } else {
                    toggleSelectionBtn.innerHTML =
                        '<i class="fa-solid fa-xmark mr-1"></i>Annuler la sélection';
                    toggleSelectionBtn.classList.remove('bg-gray-500');
                    toggleSelectionBtn.classList.add('bg-gray-500');
                }
            });

            // Submit form validation
            document.getElementById('multi-materiel-form').addEventListener('submit', function(e) {
                const checkedBoxes = document.querySelectorAll('.materiel-checkbox:checked');
                const count = checkedBoxes.length;

                if (count <= 1) {
                    e.preventDefault();
                    iziToast.warning({
                        title: 'Sélection insuffisante',
                        message: 'Veuillez sélectionner au moins deux matériels.'
                    });
                } else if (count > 8) {
                    e.preventDefault();
                    iziToast.warning({
                        title: 'Trop de matériels sélectionnés',
                        message: 'Veuillez sélectionner 8 matériels maximum.'
                    });
                }
            });

            // Update select all button to only handle selection
            selectAllBtn.addEventListener('click', function() {
                // Select up to 8 items
                materielCheckboxes.forEach((checkbox, index) => {
                    checkbox.checked = index < 8;
                });
            });

            // Add deselect all button functionality
            const deselectAllBtn = document.getElementById('deselect-all');
            deselectAllBtn.addEventListener('click', function() {
                materielCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
            });

            // Add live checkbox monitoring
            $(document).on('change', '.materiel-checkbox', function() {
                const checkedCount = $('.materiel-checkbox:checked').length;
                if (checkedCount > 8) {
                    $(this).prop('checked', false);
                    iziToast.warning({
                        title: 'Limite atteinte',
                        message: 'Vous ne pouvez pas sélectionner plus de 8 matériels.'
                    });
                }
            });
        });
    </script>
@endsection
