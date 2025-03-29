@extends('layouts.app')
@section('title', 'affectation')
@section('content')
    <div class="px-6">
        <form action="{{ route('storeExists') }}" method="post" class="form-container">
            <h1 class="text-3xl mb-3">Affectation d'un matériel à <span class="font-bold">{{$utilisateur->nom}}</span></h1>
            @csrf
            <div>
                <div class="grid grid-cols-3 gap-6">
                    <label for="nom" class="form-label">
                        Nom & Prenom :
                        <input type="text" id="nom" class="form-input focus:outline-0 bg-gray-100" name="nom"
                            value="{{ $utilisateur->nom }}" readonly required >
                        @error('nom')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <label for="fonction" class="form-label">
                        Fonction :
                        <input type="text" id="fonction" class="form-input focus:outline-0 bg-gray-100" name="fonction"
                            value="{{ $utilisateur->fonction }}" required readonly>
                        @error('fonction')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <label for="departement" class="form-label">
                        Département :
                        <input type="text" id="departement" class="form-input focus:outline-0 bg-gray-100"
                            name="departement" value="{{ $utilisateur->departement }}" readonly required>
                        @error('departement')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                </div>
                <div class="grid grid-cols-2 gap-10">
                    <label for="telephone" class="form-label">
                        Téléphone :
                        <input type="tel" id="telephone" class="form-input focus:outline-0 bg-gray-100" name="telephone"
                            value="{{ $utilisateur->telephone }}" readonly required >
                        @error('telephone')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <label for="email" class="form-label">
                        Email :
                        <input type="email" id="email" class="form-input focus:outline-0 bg-gray-100" name="email"
                            value="{{ $utilisateur->email }}" readonly required >
                        @error('email')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-6">
                <label for="date_affectation" class="form-label">
                    Date d'Affectation :
                    <input type="date" id="date_affectation" class="form-input" name="date_affectation"
                        value="{{ old('date_affectation') }}" required>
                    @error('date_affectation')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                <label for="utilisateur" class="form-label">
                    Utilisateur :
                    <input type="text" id="utilisateur" class="form-input" name="utilisateur"
                        value="{{ old('utilisateur') }}">
                    @error('utilisateur')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                <label for="chantier" class="form-label">
                    Chantier :
                    <input type="text" id="chantier" class="form-input" name="chantier" value="{{ old('chantier') }}">
                    @error('chantier')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div>
                <label for="num_serie" class="form-label">
                    Numéro de Série :
                    <input type="text" id="num_serie" class="form-input" name="num_serie" value="{{ old('num_serie') }}"
                        required>
                    @error('num_serie')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                <div class="grid grid-cols-3 gap-6">
                    <label for="fabricant" class="form-label">
                        Modèle :
                        <input type="text" id="fabricant" class="form-input focus:outline-0 bg-gray-100"
                            name="fabricant" value="{{ old('fabricant') }}" readonly>
                    </label>
                    <label for="type" class="form-label">
                        Type :
                        <input type="text" id="type" class="form-input focus:outline-0 bg-gray-100"
                            name="type" value="{{ old('type') }}" readonly>
                    </label>
                    <label for="etat" class="form-label">
                        État :
                        <input type="text" id="etat" class="form-input focus:outline-0 bg-gray-100" readonly
                            name="etat" value="{{ old('etat') }}">
                    </label>
                </div>
                {{-- processeur & ram & stockage --}}
                <div class="grid grid-cols-3 gap-6" id="ordinateur">
                    <!-- Processeur -->
                    <label class="form-label">Processeur
                        <input type="text" name="processeur" class="form-input focus:outline-0 bg-gray-100" readonly
                            id="processeur" value="{{ old('processeur') }}" required>
                        @error('processeur')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <!-- RAM -->
                    <label class="form-label">RAM
                        <input type="text" name="ram" class="form-input focus:outline-0 bg-gray-100" readonly
                            id="ram" value="{{ old('ram') }}" required>
                        @error('ram')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <!-- Stockage -->
                    <label class="form-label">Stockage
                        <input type="text" name="stockage" class="form-input focus:outline-0 bg-gray-100" readonly
                            id="stockage" value="{{ old('stockage') }}" required>
                        @error('stockage')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <input type="hidden" name="id_materiel" id="id_materiel">
                </div>
            </div>
            <button type="button" id="submitBtn" class="mt-4 bg-gray-500 w-full font-bold px-4 py-2 rounded-lg">
                Ajouter
            </button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            // Initially disable the button
            $("#submitBtn").addClass('cursor-not-allowed text-gray-400');
            $('#submitBtn').attr('type', 'button');

            $("#ordinateur").hide();

            $("#num_serie").on('keyup', function() {
                let numSerie = $(this).val();

                if (numSerie.length >= 3) {
                    $.ajax({
                        url: '/affectation/getByNum/' + numSerie,
                        method: 'GET',
                        dataType: "json",
                        success: function(data) {
                            // Enable the button and change styles
                            $("#submitBtn").removeClass('cursor-not-allowed text-gray-400')
                                .addClass('cursor-pointer text-white hover:bg-gray-700');
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
                            $("#submitBtn").removeClass(
                                'cursor-pointer text-white hover:bg-gray-700').addClass(
                                'cursor-not-allowed text-gray-400');
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
                    $("#submitBtn").removeClass('cursor-pointer text-white hover:bg-gray-700').addClass(
                        'cursor-not-allowed text-gray-400');
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
