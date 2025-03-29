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
            }

            // Étape 3 : Insérer dans la table ordinateurs (si le matériel est un ordinateur)
            if ($materiel2->type == 'PC Portable' || $materiel2->type == 'PC Bureau') {
                Ordinateur::create([
                    'materiel_id' => $materiel->id,
                ]);
            }

            // Étape 4 : Insérer dans la table imprimantes (si le matériel est une imprimante)
            if ($materiel2->type == 'Imprimante') {
                Imprimante::create([
                    'materiel_id' => $materiel->id,
                ]);
            }

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
            Affectation::create([
                'materiel_id' => $materiel->id,
                'utilisateur_id' => $utilisateur->id,
                'date_affectation' => $materiel2->date_affectation,
                'utilisateur1' => $materiel2->utilisateur,
                'statut' => $materiel2->statut === "A" ? "AFFECTE" : $materiel2->statut,
                'chantier' => $materiel2->chantier,
            ]);
        }

        $this->command->info('Données de materiels2 importées avec succès dans les autres tables.');
    }
}
