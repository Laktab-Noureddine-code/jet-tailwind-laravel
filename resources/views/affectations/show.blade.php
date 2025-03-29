@extends('layouts.app')

@section('title', 'affectation')

@section('content')
    <div class="container p-3">
        <div class="bg-white rounded-lg border border-gray-400 shadow-lg px-4 py-3">
            <!-- Formulaire -->
            <form action="{{ route('utilisateur.update', $utilisateur->id) }}" method="POST">
                @csrf
                @method('PUT')
                <h1 class="text-xl text-center mb-10">
                    <label class="">Affectations de l'utilisateur :</label>
                    <input type="text" name="nom" class="px-2 py-1 rounded-md min-w-[70%] font-bold w-full text-center"
                        value="{{ $utilisateur->nom }}" disabled>
                </h1>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Email -->
                    <div class="flex flex-col">
                        <div class="flex gap-2">
                            <label class="text-lg">Email :</label>
                            <input type="email" name="email" class="px-2 py-1 rounded-md min-w-[70%] font-bold "
                                value="{{ old('email', $utilisateur->email) }}" disabled>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="flex flex-col">
                        <div class="flex gap-2">
                            <label class="text-lg">Téléphone :</label>
                            <input type="text" name="telephone" class="px-2 py-1 rounded-md min-w-[70%] font-bold"
                                value="{{ old('telephone', $utilisateur->telephone) }}" disabled>
                        </div>
                        @error('telephone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-2">
                    <!-- Département -->
                    <div class="flex flex-col">
                        <div class="flex gap-2">
                            <label class="text-lg">Département :</label>
                            <input type="text" name="departement" class="px-2 py-1 rounded-md min-w-[70%] font-bold"
                                value="{{ old('departement', $utilisateur->departement) }}" disabled>
                        </div>
                        @error('departement')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fonction -->
                    <div class="flex flex-col">
                        <div class="flex gap-2">
                            <label class="text-lg">Fonction :</label>
                            <input type="text" name="fonction" class="px-2 py-1 rounded-md min-w-[70%] font-bold"
                                value="{{ old('fonction', $utilisateur->fonction) }}" disabled>
                        </div>
                        @error('fonction')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end mt-4">
                    <button type="button" id="edit-btn"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg cursor-pointer"><i
                            class="fas fa-edit"></i></button>
                    <button type="submit" id="save-btn"
                        class="hidden bg-green-500 text-white px-4 py-2 rounded-lg cursor-pointer ml-2"><i
                            class="fa-solid fa-floppy-disk"></i></button>
                    <button type="button" id="cancel-btn"
                        class="hidden bg-gray-500 text-white px-4 py-2 rounded-lg cursor-pointer ml-2"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
            </form>

        </div>

        <div class="bg-white rounded-lg border border-gray-400 shadow-lg px-4 py-5 mt-4">
            <h3 class="text-2xl my-4"><i class="fa-solid fa-file mr-4"></i>Liste des affectations</h3>
            <table class="text-left w-full border border-gray-400">
                <thead>
                    <tr class="tr">
                        <th class="pl-2">Modèle</th>
                        <th class="pl-2">Type</th>
                        <th class="pl-2">Numéro de série</th>
                        <th class="pl-2">Date d'affectation</th>
                        <th class="pl-2">Utilisateur</th>
                        <th class="pl-2">Statut</th>
                        <th class="pl-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($utilisateur->affectations as $affectation)
                        <tr class="border-b border-gray-400">
                            <td>{{ $affectation->materiel->fabricant }}</td>
                            <td>{{ $affectation->materiel->type }}</td>
                            <td>{{ $affectation->materiel->num_serie }}</td>
                            <td>{{ $affectation->date_affectation }}</td>
                            <td>{{ $affectation->utilisateur1 }}</td>
                            <td>{{ $affectation->statut }}</td>
                            <td class="flex items-center justify-center gap-4">
                                <form action="{{ route('affectation.destroy', $affectation) }}" method="post"
                                    class="inline-block"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette affectation')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="mr-2 cursor-pointer">
                                        <i class="fa-solid fa-trash text-red-500"></i>
                                    </button>
                                </form>
                                <a href="{{ route('generatePdf', $affectation) }}">
                                    <i class="fa-solid fa-file-pdf text-red-700"></i>
                                </a>
                                <form action="{{ route('upload', $affectation) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <label for="fiche_{{ $affectation->id }}" class="cursor-pointer">
                                        <i class="fa-solid fa-cloud-arrow-up text-blue-500"></i>
                                    </label>
                                    <input type="file" name="fiche_affectation" id="fiche_{{ $affectation->id }}"
                                        class="hidden"
                                        onchange="document.getElementById('save_{{ $affectation->id }}').classList.remove('hidden')">
                                    <button type="submit" id="save_{{ $affectation->id }}"
                                        class="hidden bg-green-500 text-white px-2 py-1 rounded-lg text-sm">
                                        Enregistrer
                                    </button>
                                </form>
                                @if ($affectation->fiche_affectation)
                                    {{-- <a href="{{ asset('storage/' . $affectation->fiche_affectation) }}"
                                        download="{{ basename($affectation->fiche_affectation) }}" target="_blank">
                                        <i class="fa-solid fa-file text-gray-600"></i>
                                    </a> --}}
                                    <a href="{{ asset('storage/' . $affectation->fiche_affectation) }}" target="_blank">
                                        <i class="fa-solid fa-file text-gray-600"></i>
                                    </a>
                                @endif
                            </td>
                            @error('fiche_affectation')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex justify-end">
                <a href="{{ route('userExists', $utilisateur->id) }}"
                    class="form-btn w-[100px] bg-gray-700 text-white font-bold text-center">
                    Ajouter
                </a>

            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $("#edit-btn").click(function() {
                // Activer les champs du formulaire
                $("input").prop("disabled", false);
                $("input").addClass('outline outline-gray-500');

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
                $("input").removeClass('outline outline-gray-500');

                // Réafficher Modifier et cacher Enregistrer + Annuler
                $("#edit-btn").show();
                $("#save-btn, #cancel-btn").addClass("hidden");
            });
        });
    </script>

@endsection
