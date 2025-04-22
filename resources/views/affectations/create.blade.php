@extends('layouts.app')

@section('title', 'Ajouter une affectation')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-[#0A1C3E] px-6 py-4">
                    <h1 class="text-xl font-semibold text-white">Ajouter une affectation</h1>
                </div>

                <form action="{{ route('affectation.store') }}" method="post" class="p-6">
                    @csrf

                    <div class="space-y-8">
                        <!-- Section 1: Informations Personnelles -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Informations Personnelles</h2>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom & Prenom</label>
                                    <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('nom')outline-2 outline-red-500 @enderror">
                                    @error('nom')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fonction</label>
                                    <input type="text" id="fonction" name="fonction" value="{{ old('fonction') }}"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('fonction')outline-2 outline-red-500 @enderror">
                                    @error('fonction')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                                    <input type="text" id="departement" name="departement"
                                        value="{{ old('departement') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('departement')outline-2 outline-red-500 @enderror">
                                    @error('departement')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                    <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('telephone')outline-2 outline-red-500 @enderror">
                                    @error('telephone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('email')outline-2 outline-red-500 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Détails de l'Affectation -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Détails de l'Affectation</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date d'Affectation</label>
                                    <input type="date" id="date_affectation" name="date_affectation"
                                        value="{{ old('date_affectation') }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('date_affectation')outline-2 outline-red-500 @enderror">
                                    @error('date_affectation')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Chantier</label>
                                    <input type="text" id="chantier" name="chantier" value="{{ old('chantier') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('chantier')outline-2 outline-red-500 @enderror">
                                    @error('chantier')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Utilisateur</label>
                                    <input type="text" id="utilisateur" name="utilisateur"
                                        value="{{ old('utilisateur') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('utilisateur')outline-2 outline-red-500 @enderror">
                                    @error('utilisateur')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Informations Matériel -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Informations Matériel</h2>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de Série</label>
                                    <input type="text" id="num_serie" name="num_serie" value="{{ old('num_serie') }}"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-[#0A1C3E] @error('num_serie')outline-2 outline-red-500 @enderror">
                                    @error('num_serie')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                                    <input type="text" id="fabricant" name="fabricant" value="{{ old('fabricant') }}"
                                        readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                    <input type="text" id="type" name="type" value="{{ old('type') }}"
                                        readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">État</label>
                                    <input type="text" id="etat" name="etat" value="{{ old('etat') }}"
                                        readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Spécifications Ordinateur -->
                        <div id="ordinateur" class="space-y-4" style="display: none;">
                            <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Spécifications Ordinateur</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Processeur</label>
                                    <input type="text" id="processeur" name="processeur"
                                        value="{{ old('processeur') }}" readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">RAM</label>
                                    <input type="text" id="ram" name="ram" value="{{ old('ram') }}"
                                        readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Stockage</label>
                                    <input type="text" id="stockage" name="stockage" value="{{ old('stockage') }}"
                                        readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id_materiel" id="id_materiel">

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('affectation.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E]">
                            Annuler
                        </a>
                        <button type="button" id="submitBtn"
                            class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-[#0A1C3E] hover:bg-[#0A1C3E]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A1C3E] disabled:opacity-50 disabled:cursor-not-allowed">
                            Ajouter l'affectation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initially disable the button
            $("#submitBtn").prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
            $('#submitBtn').attr('type', 'button');

            $("#num_serie").on('keyup', function() {
                let numSerie = $(this).val();

                if (numSerie.length >= 3) {
                    $.ajax({
                        url: '/affectation/getByNum/' + numSerie,
                        method: 'GET',
                        dataType: "json",
                        success: function(data) {
                            console.log('Success:', data);
                            // Enable the button and change styles
                            $("#submitBtn").prop('disabled', false)
                                .removeClass('opacity-50 cursor-not-allowed');
                            $('#submitBtn').attr('type', 'submit');

                            // Fill the fields with the fetched data
                            $("#fabricant").val(data.fabricant);
                            $("#type").val(data.type);
                            $("#etat").val(data.etat);
                            $("#id_materiel").val(data.id);

                            if (data.processeur || data.ram || data.stockage) {
                                $("#ordinateur").slideDown("slow");
                                $("#processeur").val(data.processeur);
                                $("#ram").val(data.ram);
                                $("#stockage").val(data.stockage);
                                $("#id_materiel").val(data.id);
                            } else {
                                $("#ordinateur").slideUp();
                                $("#processeur").val('');
                                $("#ram").val('');
                                $("#stockage").val('');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Error:', xhr, status, error);
                            // Disable the button and reset styles
                            $("#submitBtn").prop('disabled', true)
                                .addClass('opacity-50 cursor-not-allowed');
                            $('#submitBtn').attr('type', 'button');

                            // Reset all fields
                            $("#ordinateur").slideUp();
                            $("#fabricant").val('');
                            $("#type").val('');
                            $("#etat").val('');
                            $("#processeur").val('');
                            $("#ram").val('');
                            $("#stockage").val('');
                            $("#id_materiel").val('');
                        }
                    });
                } else {
                    // If the serial number is too short, disable the button and reset styles
                    $("#submitBtn").prop('disabled', true)
                        .addClass('opacity-50 cursor-not-allowed');
                    $('#submitBtn').attr('type', 'button');

                    // Reset all fields
                    $("#ordinateur").slideUp();
                    $("#fabricant").val('');
                    $("#type").val('');
                    $("#etat").val('');
                    $("#processeur").val('');
                    $("#ram").val('');
                    $("#stockage").val('');
                    $("#id_materiel").val('');
                }
            });
        });
    </script>
@endsection
