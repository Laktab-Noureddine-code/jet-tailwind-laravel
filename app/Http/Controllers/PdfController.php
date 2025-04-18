<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\BigAffectation;
use App\Models\BigAffectationRows;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Materiel;
use Illuminate\Support\Facades\Storage;
use Str;

class PdfController extends Controller
{
    public function generatePdf(Affectation $affectation)
    {
        // Récupérer l'utilisateur lié à l'affectation
        $utilisateur = $affectation->utilisateur;
        $materiel = $affectation->materiel;
        $ordinateur = $affectation->materiel->ordinateur;
        $chantier = $affectation->chantier ? $affectation->chantier : "Siege";
        $is_Computer = $materiel->type === "PC Portable" || $materiel->type === "PC Bureau";
        // Formater la date de l'affectation
        $dateAffectation = Carbon::parse($affectation->date_affectation)->format('d/m/Y');

        // Passer l'objet directement
        $data = compact('affectation', 'utilisateur', 'materiel', 'chantier', 'dateAffectation', 'ordinateur', 'is_Computer');
        // Générer le PDF
        $pdf = Pdf::loadView('pdfs.generatePdf', $data);

        // Télécharger le fichier PDF
        return $pdf->download($utilisateur->nom . "-" . $affectation->date_affectation . '.pdf');
    }
    public function generateBigAffectation(Request $request)
    {
        if ($request->has('bigAffectation')) {
            $bigAffectation = BigAffectation::with(['utilisateur', 'bigAffectationRows.materiel'])->findOrFail($request->bigAffectation);
        } else {
            // Récupérer les données du formulaire
            $utilisateur_id = $request->utilisateur_id;
            $material_ids = $request->input('selected_materiels', []);

            // Créer une seule BigAffectation
            $bigAffectation = new BigAffectation();
            $bigAffectation->utilisateur_id = $utilisateur_id;
            $bigAffectation->save();

            // Créer les BigAffectationRows pour chaque matériel
            foreach ($material_ids as $materiel_id) {
                $row = new BigAffectationRows();
                $row->big_affectation_id = $bigAffectation->id;
                $row->materiel_id = $materiel_id;
                $row->save();
            }
        }
        return redirect()->back()->with(['succes' => 'Affectation multiple crée avec succès']);
    }
    // public function generateMultiPdf(Request $request)
    // {
    //     // Si on a un bigAffectation_id, c'est qu'on veut afficher un PDF existant
    //     if ($request->has('bigAffectation')) {
    //         $bigAffectation = BigAffectation::with(['utilisateur', 'bigAffectationRows.materiel'])->findOrFail($request->bigAffectation);
    //         $utilisateur = $bigAffectation->utilisateur;
    //         $materiels = $bigAffectation->bigAffectationRows->map(function ($row) {
    //             return $row->materiel;
    //         });
    //     } else {
    //         // Récupérer les données du formulaire
    //         $utilisateur_id = $request->utilisateur_id;
    //         $material_ids = $request->input('selected_materiels', []);

    //         // Créer une seule BigAffectation
    //         $bigAffectation = new BigAffectation();
    //         $bigAffectation->utilisateur_id = $utilisateur_id;
    //         $bigAffectation->save();

    //         // Créer les BigAffectationRows pour chaque matériel
    //         foreach ($material_ids as $materiel_id) {
    //             $row = new BigAffectationRows();
    //             $row->big_affectation_id = $bigAffectation->id;
    //             $row->materiel_id = $materiel_id;
    //             $row->save();
    //         }

    //         // Récupérer l'utilisateur et les matériels
    //         $utilisateur = Utilisateur::findOrFail($utilisateur_id);
    //         $materiels = Materiel::whereIn('id', $material_ids)->get();
    //     }

    //     // Déterminer le chantier (utiliser le premier disponible)
    //     $chantier = $materiels->first() && $materiels->first()->affectations->first() && $materiels->first()->affectations->first()->chantier
    //         ? $materiels->first()->affectations->first()->chantier
    //         : "Siege";

    //     // Générer un nom de fichier unique
    //     $fileName = $utilisateur->nom . '-' . date('Ymd') . '--' . uniqid() . '.pdf';

    //     // Data pour la vue PDF
    //     $data = [
    //         'utilisateur' => $utilisateur,
    //         'materiels' => $materiels,
    //         'chantier' => $chantier,
    //         'is_multiple' => true,
    //         'date_affectation' => $bigAffectation->created_at->format('d/m/Y')
    //     ];
    //     // return redirect()->back();
    //     // Générer le PDF
    //     $pdf = Pdf::loadView('pdfs.multiGeneratePdf', $data);
    //     // Télécharger le fichier PDF
    //     return $pdf->download($fileName);
    //     // return redirect()->back();
    // }


    public function generateMultiPdf(Request $request)
    {
        // Validate that a bigAffectation ID is provided
        $request->validate([
            'bigAffectation' => 'required|exists:big_affectations,id',
        ]);

        // Retrieve the BigAffectation with its relationships
        $bigAffectation = BigAffectation::with(['utilisateur', 'bigAffectationRows.materiel.affectations'])->findOrFail($request->bigAffectation);

        // Extract the utilisateur and materiels
        $utilisateur = $bigAffectation->utilisateur;
        $materiels = $bigAffectation->bigAffectationRows->map(function ($row) {
            return $row->materiel;
        });

        // Determine the chantier (default to "Siege" if not available)
        $chantier = $materiels->flatMap(function ($materiel) {
            return $materiel->affectations;
        })->first()?->chantier ? $materiels->flatMap(function ($materiel) {
            return $materiel->affectations;
        })->first()?->chantier : "Siege";

        // Generate a unique file name
        $fileName = $utilisateur->nom . '-' . date('Ymd') . '--' . uniqid() . '.pdf';


        // Prepare data for the PDF view
        $data = [
            'utilisateur' => $utilisateur,
            'materiels' => $materiels->map(function ($materiel) {
                // Get the first affectation's date for the material, or default to the current date
                $date_affectation = $materiel->affectations->first()?->date_affectation ?? now();

                return [
                    'materiel' => $materiel,
                    'date_affectation' => Carbon::parse($date_affectation)->format('d/m/Y'),
                ];
            }),
            'chantier' => $chantier,
            'is_multiple' => true,
        ];

        // Generate the PDF
        $pdf = Pdf::loadView('pdfs.multiGeneratePdf', $data);

        // Download the PDF
        return $pdf->download($fileName);
    }
    public function deleteBigAffectation(BigAffectation $bigAffectation)
    {
        try {
            // Supprimer le fichier s'il existe
            if ($bigAffectation->fiche_affectations) {
                Storage::disk('public')->delete($bigAffectation->fiche_affectations);
            }

            // Supprimer les BigAffectationRows associées
            $bigAffectation->bigAffectationRows()->delete();

            // Supprimer la BigAffectation
            $bigAffectation->delete();

            return redirect()->back()->with('success', 'Affectation multiple supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression de l\'affectation multiple');
        }
    }
}
