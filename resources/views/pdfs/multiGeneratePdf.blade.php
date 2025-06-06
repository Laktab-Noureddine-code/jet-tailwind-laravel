<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du Matériel</title>
    <style>
        body {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100vh
        }

        header,
        footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }

        header {
            top: 0;
        }

        footer {
            bottom: 0;
        }

        #ligne {
            margin-top: -15px;
            height: 5px;
            width: 85%;
            background-color: #f4d103;
        }

        main {
            margin-top: 190px;
            min-height: 500px;
        }

        main table tr td {
            height: 34px;
        }
    </style>
</head>

<body>
    <header>
        <table width="100%">
            <tr>
                <td style="text-align: left; vertical-align: text-top;">
                    <img src="{{ public_path('/title.png') }}" style="width: 230px;">
                    <p style=" color: #222; font-size: 7px;">
                        TCE - Enveloppes de Bâtiments - Constructions Métalliques<br /> Ouvrages D'art - Ossature Bois -
                        EPC
                        solaire...
                    </p>
                </td>
                <td style="text-align: right;">
                    <img src="{{ public_path('/logo1.png') }}" style="max-width: 200px;">
                </td>
            </tr>
        </table>
        <div style="margin-top: 20px;">
            <h3 style="text-align:left;"><strong>FICHE D'AFFECTATION DE MATÉRIEL INFORMATIQUE</strong></h3>
            <div id="ligne"></div>
        </div>
    </header>

    <main>

        <div>
            <table width="100%">
                <tr>
                    <td style="width: 33%;">Nom & Prenom :
                    </td>
                    <td>
                        <span>
                            <strong style="text-transform: uppercase;">{{ $utilisateur->nom }}</strong>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 33%;">Email :
                    </td>
                    <td>
                        <span>
                            <strong>{{ $utilisateur->email }}</strong>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 33%;">Fonction :
                    </td>
                    <td>
                        <span>
                            <strong>{{ $utilisateur->fonction }}</strong>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 33%;">Téléphone :
                    </td>
                    <td>
                        <span>
                            <strong>{{ $utilisateur->telephone }}</strong>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 33%;">Département :
                    </td>
                    <td>
                        <span>
                            <strong>{{ $utilisateur->departement }}</strong>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 33%;">Siege / Chantier :
                    </td>
                    <td>
                        <span>
                            <strong>{{ $chantier }}</strong>
                        </span>
                    </td>
                </tr>
            </table>

            @php
                $materialsCount = $materiels->count();
                // Calculate margin based on number of materials
                $marginTop = match (true) {
                    $materialsCount <= 2 => 120,
                    $materialsCount <= 4 => 70,
                    $materialsCount <= 6 => 40,
                    default => 20,
                };
            @endphp
            <table width="100%"
                style="margin-top: {{ $marginTop }}px; border-collapse: collapse; border: 1px solid #000;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #000; padding: 2px; background-color: #dcc01f; color: #000;">Type
                            de
                            matériel</th>
                        <th style="border: 1px solid #000; padding: 2px; background-color: #dcc01f; color: #000;">Modèle
                        </th>
                        <th style="border: 1px solid #000; padding: 2px; background-color: #dcc01f; color: #000;">Numéro
                            de
                            série</th>
                        <th style="border: 1px solid #000; padding: 2px; background-color: #dcc01f; color: #000;">Date
                            d'affectation</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($materiels as $item)
                        <tr style="text-align: center;">
                            <!-- Access the 'type' property of the 'materiel' object -->
                            <td style="border: 1px solid #000; padding: 2px;">
                                {{ $item['materiel']->type === 'Telephone' ? 'Téléphone' : $item['materiel']->type }}
                            </td>

                            <!-- Access the 'fabricant' property of the 'materiel' object -->
                            <td style="border: 1px solid #000; padding: 2px;">{{ $item['materiel']->fabricant }}
                                @if ($item['materiel']->type === 'PC Portable' || $item['materiel']->type === 'PC Bureau')
                                    {{ $item['materiel']->ordinateur->processeur }}
                                    {{ $item['materiel']->ordinateur->ram }}
                                    {{ $item['materiel']->ordinateur->stockage }}
                                @endif
                            </td>

                            <!-- Access the 'num_serie' property of the 'materiel' object -->
                            <td style="border: 1px solid #000; padding: 2px;">{{ $item['materiel']->num_serie }}</td>

                            <!-- Display the 'date_affectation' from the array -->
                            <td style="border: 1px solid #000; padding: 2px;">{{ $item['date_affectation'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    <footer class="footer">
        <table width="100%">
            <tr>
                <td width="33%">
                    <div style="text-align: center;">
                        <div style="font-weight: bolder; display: inline-block;">Bénéficiaire</div>
                        <div style="width: 100px; height: 5px; background-color: #f4d103; margin: 5px auto;"></div>
                    </div>
                </td>
                <td width="33%">
                    <div style="text-align: center;">
                        <div style="font-weight: bolder; display: inline-block;">SI</div>
                        <div style="width: 40px; height: 5px; background-color: #f4d103; margin: 5px auto;"></div>
                    </div>
                </td>
                <td width="33%">
                    <div style="text-align: center;">
                        <div style="font-weight: bolder; display: inline-block;">DRH</div>
                        <div style="width: 50px; height: 5px; background-color: #f4d103; margin: 5px auto;"></div>
                    </div>
                </td>
            </tr>
        </table>
        <table width="100%" style="font-size: 8px; margin-top: 140px;font-weight: 700;">
            <tr>
                <td width="25%" style="text-align: left; vertical-align: middle;">
                    Quartier Industriel de Oued Yquem<br>
                    CP 12040 Skhinate - Maroc<br>
                </td>
                <!-- Pied de page avec les adresses -->
                <td width="25%" style="vertical-align: middle; ">
                    Tél : (212) 537 74 92 92<br>
                    Fax : (212) 537 74 92 30<br>
                    contact@jet-contractors.com<br>
                </td>
                <td width="25%" style=" vertical-align: middle; font-weight: 900;">
                    <strong>www.jet-contractors.com</strong><br>
                    <img src="{{ public_path('/lien.png') }}" style="height: 10px;">
                </td>
                <td width="25%" style="text-align: center; vertical-align: middle; ">
                    <img src="{{ public_path('/Certifica.jpg') }}" style="width: 80%;">
                </td>
            </tr>
        </table>
    </footer>
</body>

</html>
