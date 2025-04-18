<!DOCTYPE html>
<html>

<head>
    <title>Détails de l'Affectation des Matériels</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .content {
            background-color: #ffffff;
            padding: 20px;
        }

        .signature {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .contact-info {
            color: #333;
            font-size: 14px;
        }

        .logo {
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
        }

        .details {
            margin: 20px 0;
            padding-left: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <p>Madame/Monsieur {{ $utilisateur->nom }},</p>

            <p>Je vous écris pour vous confirmer les affectations des matériels IT suivants :</p>

            @if ($materiels->isNotEmpty())
                <table>
                    <thead>
                        <tr>
                            <th>Type de Matériel</th>
                            <th>Fabricant</th>
                            <th>Numéro de Série</th>
                            <th>Date d'Affectation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materiels as $item)
                            <tr>
                                <td>{{ $item['materiel']->type === 'Telephone' ? 'Téléphone' : $materiel->type  }}</td>
                                <td>{{ $item['materiel']->fabricant }}</td>
                                <td>{{ $item['materiel']->num_serie }}</td>
                                <td>{{ date('d/m/Y', strtotime($item['date_affectation'])) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p><strong>Aucun matériel associé à cette affectation.</strong></p>
            @endif

            <p>Nous avons bien pris en compte votre demande et les matériels ont été affectés conformément aux procédures de notre département. Si vous avez besoin de plus d'informations ou si des ajustements sont nécessaires, n'hésitez pas à me contacter.</p>

            <div class="signature">
                <p>Cordialement,</p>
                <p><strong>Direction IT</strong></p>
                <img src="{{ public_path('/logo1.png') }}" alt="">
                <div class="contact-info">
                    <p>JET CONTRACTORS</p>
                    <p>Quartier Industriel de Oued Yquem CP 12040 Skhirate - Maroc</p>
                    <p>Tél : +(212) 6 62 57 23 00</p>
                    <p>www.jet-contractors.com</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>