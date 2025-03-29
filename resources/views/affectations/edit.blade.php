@extends('layouts.app')

@section('title', 'affectation')

@section('content')
    <div class="px-6">
        <form action="{{ route('affectation.update', $affectation) }}" method="post" class="form-container">
            @csrf
            @method('PUT')
            <h1 class="header-title">Modifier l'affectation</h1>
            <div>
                <div class="grid grid-cols-3 gap-6">
                    <label for="nom" class="form-label">
                        Nom & Prenom :
                        <input type="text" id="nom" class="form-input" name="nom"
                            value="{{ old('nom', $utilisateur->nom) }}" required>
                        @error('nom')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <label for="fonction" class="form-label">
                        Fonction :
                        <input type="text" id="fonction" class="form-input" name="fonction"
                            value="{{ old('fonction', $utilisateur->fonction) }}" required>
                        @error('fonction')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <label for="departement" class="form-label">
                        Département :
                        <input type="text" id="departement" class="form-input" name="departement"
                            value="{{ old('departement', $utilisateur->departement) }}" required>
                        @error('departement')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                </div>
                <div class="grid grid-cols-2 gap-10">
                    <label for="telephone" class="form-label">
                        Téléphone :
                        <input type="tel" id="telephone" class="form-input" name="telephone"
                            value="{{ old('telephone', $utilisateur->telephone) }}" required>
                        @error('telephone')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <label for="email" class="form-label">
                        Email :
                        <input type="email" id="email" class="form-input" name="email"
                            value="{{ old('email', $utilisateur->email) }}" required>
                        @error('email')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-10">
                <label for="date_affectation" class="form-label">
                    Date d'Affectation :
                    <input type="date" id="date_affectation" class="form-input" name="date_affectation"
                        value="{{ old('date_affectation', $affectation->date_affectation) }}" required>
                    @error('date_affectation')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                <label for="chantier" class="form-label">
                    Chantier :
                    <input type="text" id="chantier" class="form-input" name="chantier"
                        value="{{ old('chantier', $affectation->chantier) }}">
                    @error('chantier')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                <label for="utilisateur" class="form-label">
                    Utilisateur :
                    <input type="text" id="utilisateur" class="form-input" name="utilisateur"
                        value="{{ old('utilisateur', $affectation->utilisateur) }}">
                    @error('utilisateur')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="grid grid-cols-2 gap-10">
                <label for="num_serie" class="form-label">
                    Numéro de Série :
                    <input type="text" id="num_serie" class="form-input" name="num_serie"
                        value="{{ old('num_serie', $materiel->num_serie) }}" required>
                    @error('num_serie')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                <label for="statut" class="form-label">
                    Statut :
                    <select name="statut" id="statut" class="form-input">
                        <option {{ $affectation->statut === 'AFFECTE' ? 'selected' : '' }} value="AFFECTE">AFFECTE</option>
                        <option {{ $affectation->statut === 'REAFFECTE' ? 'selected' : '' }} value="REAFFECTE">REAFFECTE
                        </option>
                        <option {{ $affectation->statut === 'NON AFFECTE' ? 'selected' : '' }} value="NON AFFECTE">NON
                            AFFECTE</option>
                    </select>
                    @error('statut')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>

            </div>
            <div class="grid grid-cols-3 gap-6">
                <label for="fabricant" class="form-label">
                    Modèle :
                    <input type="text" id="fabricant" class="form-input focus:outline-0 bg-gray-100" name="fabricant"
                        value="{{ old('fabricant', $materiel->fabricant) }}" readonly>
                    @error('fabricant')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                <label for="type" class="form-label">
                    Type :
                    <input type="text" id="type" class="form-input focus:outline-0 bg-gray-100" name="type"
                        value="{{ old('type', $materiel->type) }}" readonly>
                    @error('type')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                <label for="etat" class="form-label">
                    État :
                    <input type="text" id="etat" class="form-input focus:outline-0 bg-gray-100" readonly
                        name="etat" value="{{ old('etat', $materiel->etat) }}">
                    @error('etat')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </label>
            </div>


            <div id="ordinateur"
                style="display: {{ $materiel->type === 'Pc Bureau' || $materiel->type === 'Pc Portable' ? 'block' : 'none' }};">
                <div class="grid grid-cols-3 gap-6">
                    <!-- Processeur -->
                    <label class="form-label">Processeur
                        <input type="text" name="processeur" class="form-input focus:outline-0 bg-gray-100" readonly
                            id="processeur" value="{{ old('processeur', $ordinateur ? $ordinateur->processeur : '') }}"
                            required>
                        @error('processeur')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <!-- RAM -->
                    <label class="form-label">RAM
                        <input type="text" name="ram" class="form-input focus:outline-0 bg-gray-100" readonly
                            id="ram" value="{{ old('ram', $ordinateur ? $ordinateur->ram : '') }}" required>
                        @error('ram')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <!-- Stockage -->
                    <label class="form-label">Stockage
                        <input type="text" name="stockage" class="form-input focus:outline-0 bg-gray-100" readonly
                            id="stockage" value="{{ old('stockage', $ordinateur ? $ordinateur->stockage : '') }}" required>
                        @error('stockage')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                </div>
            </div>
            <button type="button" id="submitBtn" class="mt-4 bg-gray-500 w-full font-bold px-4 py-2 rounded-lg ">
                Modifier
            </button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Initially disable the button
            $("#submitBtn").addClass('cursor-not-allowed text-gray-400');
            $('#submitBtn').attr('type', 'button');

            // $("#ordinateur").hide();

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
