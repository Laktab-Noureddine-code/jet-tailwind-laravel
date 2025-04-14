</html>
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

        #ligne {
            margin-top: -15px;
            height: 5px;
            width: 85%;
            background-color: #f4d103;
        }
    </style>
</head>

<body>
    <div class="">
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

        <div style="margin-top: 30px;">
            <h3><strong>FICHE D'AFFECTATION DE MATÉRIEL INFORMATIQUE</strong></h3>
            <div id="ligne"></div>
        </div>

        <table width="100%" style="margin-top: 40px;">
            <tr>
                <td style="height:45px; width: 33%;">Nom & Prenom :
                </td>
                <td>
                    <span>
                        <strong>{{ $utilisateur->nom }}</strong>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="height:45px; width: 33%;">Email :
                </td>
                <td>
                    <span>
                        <strong>{{ $utilisateur->email }}</strong>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="height:45px; width: 33%;">Fonction :
                </td>
                <td>
                    <span>
                        <strong>{{ $utilisateur->fonction }}</strong>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="height:45px; width: 33%;">Téléphone :
                </td>
                <td>
                    <span>
                        <strong>{{ $utilisateur->telephone }}</strong>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="height:45px; width: 33%;">Département :
                </td>
                <td>
                    <span>
                        <strong>{{ $utilisateur->departement }}</strong>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="height:45px; width: 33%;">Siege / Chantier :
                </td>
                <td>
                    <span>
                        <strong>{{ $chantier }}</strong>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="height:45px; width: 33%;">Date affectation :
                </td>
                <td>
                    <span>
                        <strong>{{ $dateAffectation }}</strong>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="height:45px; width: 33%;">Modèle :
                </td>
                <td>
                    <span>
                        <strong>{{ $materiel->fabricant }} {{ $ordinateur->processeur }} {{ $ordinateur->ram }}
                            {{ $ordinateur->stockage }}</strong>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="height:45px; width: 33%;">Type de matériel :
                </td>
                <td>
                    <span>
                        <strong>{{ $materiel->type }}</strong>
                    </span>
                </td>
            </tr>
            <tr>
                <td style="height:45px; width: 33%;">Numéro de série :
                </td>
                <td>
                    <span>
                        <strong>{{ $materiel->num_serie }}</strong>
                    </span>
                </td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 50px;">
            <tr>
                <td width="33%">
                    <div style="text-align: center;">
                        <div style="font-weight: bolder; display: inline-block;">bénéficiaire</div>
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
        <table width="100%" style="font-size: 8px; margin-top: 160px;font-weight: 700;">
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
    </div>
</body>

</html>
