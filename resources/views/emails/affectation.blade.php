<!DOCTYPE html>
<html>

<head>
    <title>Confirmation d'Affectation de Matériel IT</title>
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

            <p>Je vous écris pour vous confirmer l'affectation du matériel IT suivant :</p>
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
                    <tr>
                        <td>{{ $materiel->type === 'Telephone' ? 'Téléphone' : $materiel->type }}
                        </td>
                        <td>{{ $materiel->fabricant }}</td>
                        <td>{{ $materiel->num_serie }}</td>
                        <td>{{ date('d/m/Y', strtotime($affectation->date_affectation)) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
