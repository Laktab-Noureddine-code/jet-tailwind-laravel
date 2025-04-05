@extends('layouts.app')

@section('title', 'affectation')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-[#0A1C3E]">Ajouter une affectation</h1>
                </div>

                <form action="{{ route('affectation.store') }}" method="post" class="p-6 space-y-6">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations Personnelles</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <label class="block">
                                <span class="text-gray-700 font-medium">Nom & Prenom</span>
                                <input type="text" id="nom"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                            <label class="block">
                                <span class="text-gray-700 font-medium">Fonction</span>
                                <input type="text" id="fonction"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="fonction" value="{{ old('fonction') }}" required>
                                @error('fonction')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                            <label class="block">
                                <span class="text-gray-700 font-medium">Département</span>
                                <input type="text" id="departement"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="departement" value="{{ old('departement') }}" required>
                                @error('departement')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label class="block">
                                <span class="text-gray-700 font-medium">Téléphone</span>
                                <input type="tel" id="telephone"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="telephone" value="{{ old('telephone') }}" required>
                                @error('telephone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                            <label class="block">
                                <span class="text-gray-700 font-medium">Email</span>
                                <input type="email" id="email"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>
                    </div>

                    <!-- Affectation Details Section -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Détails de l'Affectation</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <label class="block">
                                <span class="text-gray-700 font-medium">Date d'Affectation</span>
                                <input type="date" id="date_affectation"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="date_affectation" value="{{ old('date_affectation') }}" required>
                                @error('date_affectation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                            <label class="block">
                                <span class="text-gray-700 font-medium">Chantier</span>
                                <input type="text" id="chantier"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="chantier" value="{{ old('chantier') }}">
                                @error('chantier')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                            <label class="block">
                                <span class="text-gray-700 font-medium">Utilisateur</span>
                                <input type="text" id="utilisateur"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="utilisateur" value="{{ old('utilisateur') }}">
                                @error('utilisateur')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>
                    </div>

                    <!-- Material Information Section -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations Matériel</h2>
                        <div class="grid grid-cols-1 gap-6">
                            <label class="block">
                                <span class="text-gray-700 font-medium">Numéro de Série</span>
                                <input type="text" id="num_serie"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="num_serie" value="{{ old('num_serie') }}" required>
                                @error('num_serie')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <label class="block">
                                <span class="text-gray-700 font-medium">Modèle</span>
                                <input type="text" id="fabricant"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="fabricant" value="{{ old('fabricant') }}" readonly>
                                @error('fabricant')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                            <label class="block">
                                <span class="text-gray-700 font-medium">Type</span>
                                <input type="text" id="type"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="type" value="{{ old('type') }}" readonly>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                            <label class="block">
                                <span class="text-gray-700 font-medium">État</span>
                                <input type="text" id="etat"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    name="etat" value="{{ old('etat') }}" readonly>
                                @error('etat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>
                    </div>

                    <!-- Computer Specifications Section -->
                    <div id="ordinateur" class="bg-gray-50 rounded-lg p-4 space-y-6" style="display: none;">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Spécifications Ordinateur</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <label class="block">
                                <span class="text-gray-700 font-medium">Processeur</span>
                                <input type="text" name="processeur"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    id="processeur" value="{{ old('processeur') }}" readonly required>
                                @error('processeur')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                            <label class="block">
                                <span class="text-gray-700 font-medium">RAM</span>
                                <input type="text" name="ram"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    id="ram" value="{{ old('ram') }}" readonly required>
                                @error('ram')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                            <label class="block">
                                <span class="text-gray-700 font-medium">Stockage</span>
                                <input type="text" name="stockage"
                                    class="mt-1 block w-full px-4 py-2.5 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1C3E] focus:border-transparent transition duration-200"
                                    id="stockage" value="{{ old('stockage') }}" readonly required>
                                @error('stockage')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="id_materiel" id="id_materiel">

                    <div class="flex justify-end pt-6">
                        <button type="button" id="submitBtn"
                            class="px-6 py-3 bg-[#0A1C3E] text-white font-medium rounded-lg shadow-sm hover:bg-opacity-90 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
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
                            // Enable the button and change styles
                            $("#submitBtn").prop('disabled', false)
                                .removeClass('opacity-50 cursor-not-allowed');
                            $('#submitBtn').attr('type', 'submit');

                            // Fill the fields with the fetched data
                            $("#fabricant").val(data.fabricant);
                            $("#type").val(data.type);
                            $("#etat").val(data.etat);
                            $("#id_materiel").val(data.id);

                            if (data.processeur && data.ram && data.stockage) {
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
                        error: function() {
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
