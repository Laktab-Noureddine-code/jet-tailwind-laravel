<?php

namespace Database\Seeders;

use App\Models\Affectation;
use App\Models\Imprimante;
use App\Models\Materiel;
use App\Models\Ordinateur;
use App\Models\Type;
use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Materiels2Seeder extends Seeder
{

    public function run()
    {
        // inserer les types de materiels
        $types = [
            "PC Portable",
            "PC Bureau",
            "Routeur",
            "Imprimante",
            "Clavier",
            "Souris",
            "Telephone",
            "Disque Externe"
        ];
        foreach ($types as $type) {
            Type::create(['type' => $type]);
        }
        User::create(
            [
                'name' => 'laktab',
                'email' => 'noureddine.laktab15@gmail.com',
                'password' => "12345678",
                'role' => 'admin'
            ]
        );


        // Étape 1 : Lire les données de la table materiels2
        $materiels2 = DB::table('materiels2')
            ->distinct()
            ->orderBy('date_affectation', 'asc')
            ->get();

        // Tableaux pour le suivi
        $materielIDs = [];

        // Première étape : Créer tous les utilisateurs et matériels uniques
        foreach ($materiels2 as $materiel2) {
            // Vérifier si le matériel existe déjà par son num_serie
            $materiel = Materiel::where('num_serie', $materiel2->num_serie)->first();

            // Si le matériel n'existe pas, on le crée
            if (!$materiel) {
                $materiel = Materiel::create([
                    'num_serie' => $materiel2->num_serie,
                    'fabricant' => $materiel2->fabricant,
                    'type' => $materiel2->type,
                    'etat' => $materiel2->etat,
                ]);

                // Créer les relations spécifiques selon le type
                if ($materiel2->type == 'PC Portable' || $materiel2->type == 'PC Bureau') {
                    Ordinateur::create([
                        'materiel_id' => $materiel->id,
                    ]);
                } elseif ($materiel2->type == 'Imprimante') {
                    Imprimante::create([
                        'materiel_id' => $materiel->id,
                    ]);
                }
            }

            // Stocker l'ID du matériel pour référence ultérieure
            $materielIDs[$materiel2->num_serie] = $materiel->id;

            // Vérifier si l'utilisateur existe déjà par son email
            $utilisateur = Utilisateur::where('email', $materiel2->email)->first();

            // Si l'utilisateur n'existe pas, on le crée
            if (!$utilisateur) {
                $utilisateur = Utilisateur::create([
                    'nom' => $materiel2->nom,
                    'fonction' => $materiel2->fonction,
                    'telephone' => $materiel2->telephone,
                    'email' => $materiel2->email,
                    'departement' => $materiel2->departement,
                ]);
            }
        }

        // Deuxième étape : Supprimer toutes les affectations existantes
        Affectation::truncate();

        // Troisième étape : Créer les affectations
        foreach ($materiels2 as $materiel2) {
            $materiel = Materiel::where('num_serie', $materiel2->num_serie)->first();
            $utilisateur = Utilisateur::where('email', $materiel2->email)->first();

            Affectation::create([
                'materiel_id' => $materiel->id,
                'utilisateur_id' => $utilisateur->id,
                'date_affectation' => $materiel2->date_affectation,
                'utilisateur1' => $materiel2->utilisateur,
                'statut' => $materiel2->statut === "A" ? "AFFECTE" : $materiel2->statut,
                'chantier' => $materiel2->chantier,
            ]);
        }

        // Quatrième étape : Mettre à jour les statuts en fonction des affectations multiples
        foreach ($materielIDs as $numSerie => $materielId) {
            // Trouver toutes les affectations pour ce matériel, triées par date
            $affectations = Affectation::where('materiel_id', $materielId)
                ->orderBy('date_affectation', 'asc')
                ->get();

            // S'il y a plus d'une affectation pour ce matériel
            if ($affectations->count() > 1) {
                // Mettre à jour toutes les affectations sauf la dernière à "NON AFFECTE"
                foreach ($affectations as $index => $affectation) {
                    if ($index < $affectations->count() - 1) {
                        $affectation->statut = "NON AFFECTE";
                        $affectation->save();
                    } else {
                        // La dernière affectation devient "REAFFECTE"
                        $affectation->statut = "REAFFECTE";
                        $affectation->save();
                    }
                }
            }
        }

        $this->command->info('Données de materiels2 importées avec succès dans les autres tables.');
    }
}
