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
                <div class="bg-[#0A1C3E] px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">Liste des affectations</h2>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if ($affectation->materiel)
                                                {{ $affectation->materiel->fabricant }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if ($affectation->materiel)
                                                {{ $affectation->materiel->type }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if ($affectation->materiel)
                                                {{ $affectation->materiel->num_serie }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $affectation->date_affectation }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $affectation->utilisateur1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $affectation->statut }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center space-x-4">
                                                <form action="{{ route('affectation.destroy', $affectation) }}"
                                                    method="post"
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
                                                <form action="{{ route('upload', $affectation) }}" method="POST"
                                                    enctype="multipart/form-data" class="inline">
                                                    @csrf
                                                    @method('POST')
                                                    <label for="fiche_{{ $affectation->id }}"
                                                        title="Ajouter une fiche d'affectation"
                                                        class="cursor-pointer text-blue-500 hover:text-blue-700">
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
                                                    <a href="{{ asset('storage/' . $affectation->fiche_affectation) }}"
                                                        title="télécharger la fiche d'affectation" target="_blank"
                                                        class="text-gray-600 hover:text-gray-800">
                                                        <i class="fa-solid fa-file"></i>
                                                    </a>
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
    </script>
@endsection
