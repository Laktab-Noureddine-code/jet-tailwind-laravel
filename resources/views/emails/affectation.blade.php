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
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <p>Madame/Monsieur {{ $utilisateur->nom }},</p>

            <p>Je vous écris pour vous confirmer l'affectation du matériel IT suivant :</p>

            <div class="details">
                <p><strong>Matériel :</strong> {{ $materiel->type === 'Telephone' ? 'Téléphone' : $materiel->type  }}</p>
                <p><strong>Modèle :</strong> {{ $materiel->fabricant }}</p>
                <p><strong>Numéro de série :</strong> {{ $materiel->num_serie }}</p>
                <p><strong>Date d'affectation :</strong> {{ date('d/m/Y', strtotime($affectation->date_affectation)) }}
                </p>
                <p><strong>Département :</strong> {{ $utilisateur->departement }}</p>
            </div>

            <p>Nous avons bien pris en compte votre demande et le matériel a été affecté conformément aux procédures de
                notre département. Si vous avez besoin de plus d'informations ou si des ajustements sont nécessaires,
                n'hésitez pas à me contacter.</p>

            {{-- <div class="signature">
                <p>Cordialement,</p>
                <p><strong>Direction RH</strong></p>
                <img src="{{ public_path('/logo1.png') }}" alt="">
                <div class="contact-info">
                    <p>JET CONTRACTORS</p>
                    <p>Quartier Industriel de Oued Yquem CP 12040 Skhirate - Maroc</p>
                    <p>Tél : +(212) 6 62 57 23 00</p>
                    <p>www.jet-contractors.com</p>
                </div>
            </div> --}}
        </div>
    </div>
</body>

</html>
