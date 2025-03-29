<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PdfController extends Controller
{
    public function generatePdf(Affectation $affectation)
    {
        // Récupérer l'utilisateur lié à l'affectation
        $utilisateur = $affectation->utilisateur;
        $materiel = $affectation->materiel;
        $chantier = $affectation->chantier ? $affectation->chantier : "Siege";
        // Formater la date de l'affectation
        $dateAffectation = Carbon::parse($affectation->date_affectation)->format('d/m/Y');

        // Passer l'objet directement
        $data = compact('affectation', 'utilisateur', 'materiel', 'chantier', 'dateAffectation');
        // Générer le PDF
        $pdf = Pdf::loadView('pdfs.generatePdf', $data);

        // Télécharger le fichier PDF
        return $pdf->download($utilisateur->nom . "-" . $affectation->date_affectation . '.pdf');
    }
}
