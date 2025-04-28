<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Type;
use App\Models\Materiel;
use App\Models\Utilisateur;
use App\Models\Affectation;
use App\Models\Ordinateur;
use App\Models\Imprimante;
use App\Models\Telephone;
use App\Models\Recrutement;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        // Création des types
        $types = [
            'PC Portable',
            'PC Bureau',
            'Imprimante',
            'Telephone',
            'Clavier',
            'Souris',
        ];
        foreach ($types as $type) {
            Type::create(['type' => $type]);
        }

        // Création des utilisateurs système
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Création des utilisateurs (30)
        for ($i = 0; $i < 30; $i++) {
            Utilisateur::create([
                'nom' => $faker->name,
                'fonction' => $faker->jobTitle,
                'telephone' => $faker->phoneNumber,
                'email' => $faker->email,
                'departement' => $faker->randomElement(['IT', 'RH', 'Finance', 'Marketing', 'Production'])
            ]);
        }

        // Création des matériels (30 pour chaque catégorie principale)
        // Ordinateurs (PC Portable et PC Bureau)
        for ($i = 0; $i < 30; $i++) {
            $type = $faker->randomElement(['PC Portable', 'PC Bureau']);
            $materiel = Materiel::create([
                'num_serie' => 'PC' . $faker->unique()->numberBetween(10000, 99999),
                'fabricant' => $faker->randomElement(['HP', 'Dell', 'Lenovo', 'Apple', 'Samsung']),
                'type' => $type,
                'etat' => $faker->randomElement(['Neuf', 'Occasion'])
            ]);

            Ordinateur::create([
                'materiel_id' => $materiel->id,
                'ram' => $faker->randomElement(['8GB', '16GB', '32GB']),
                'stockage' => $faker->randomElement(['256GB SSD', '512GB SSD', '1TB SSD', '2TB HDD']),
                'processeur' => $faker->randomElement(['Intel i5', 'Intel i7', 'Intel i9', 'AMD Ryzen 5', 'AMD Ryzen 7'])
            ]);
        }

        // Périphériques
        $peripheriques = [
            'Clavier' => ['Clavier sans fil', 'Clavier mécanique', 'Clavier ergonomique'],
            'Souris' => ['Souris sans fil', 'Souris gaming', 'Souris ergonomique'],
            'Écran' => ['24 pouces', '27 pouces', '32 pouces'],
            'Dock Station' => ['USB-C', 'Thunderbolt'],
            'Webcam' => ['HD', 'Full HD', '4K'],
            'Casque' => ['Filaire', 'Bluetooth', 'Sans fil']
        ];

        foreach ($peripheriques as $type => $modeles) {
            for ($i = 0; $i < 30; $i++) {
                Materiel::create([
                    'num_serie' => substr($type, 0, 2) . $faker->unique()->numberBetween(10000, 99999),
                    'fabricant' => $faker->randomElement(['Logitech', 'Microsoft', 'Dell', 'HP', 'Corsair']),
                    'type' => $type,
                    'etat' => $faker->randomElement(['Neuf', 'Occasion'])
                ]);
            }
        }

        // Imprimantes
        for ($i = 0; $i < 30; $i++) {
            $materiel = Materiel::create([
                'num_serie' => 'IMP' . $faker->unique()->numberBetween(10000, 99999),
                'fabricant' => $faker->randomElement(['HP', 'Canon', 'Epson', 'Brother']),
                'type' => 'Imprimante',
                'etat' => $faker->randomElement(['Neuf', 'Occasion'])
            ]);

            Imprimante::create([
                'materiel_id' => $materiel->id,
                'identifiant_noir' => 'TNR' . $faker->numberBetween(100, 999),
                'identifiant_bleu' => 'TNB' . $faker->numberBetween(100, 999),
                'identifiant_magenta' => 'TNM' . $faker->numberBetween(100, 999),
                'identifiant_jaune' => 'TNY' . $faker->numberBetween(100, 999),
                'toner_noir' => $faker->numberBetween(0, 100),
                'toner_bleu' => $faker->numberBetween(0, 100),
                'toner_magenta' => $faker->numberBetween(0, 100),
                'toner_jaune' => $faker->numberBetween(0, 100)
            ]);
        }

        // Téléphones
        for ($i = 0; $i < 30; $i++) {
            $materiel = Materiel::create([
                'num_serie' => 'TEL' . $faker->unique()->numberBetween(10000, 99999),
                'fabricant' => $faker->randomElement(['Apple', 'Samsung', 'Google', 'Xiaomi']),
                'type' => 'Telephone',
                'etat' => $faker->randomElement(['Neuf', 'Occasion'])
            ]);

            Telephone::create([
                'materiel_id' => $materiel->id,
                'pin' => $faker->numerify('####'),
                'puk' => $faker->numerify('########')
            ]);
        }

        // Création des affectations (120 - pour avoir une bonne distribution)
        for ($i = 0; $i < 190; $i++) {
            Affectation::create([
                'materiel_id' => $faker->numberBetween(1, Materiel::count()),
                'utilisateur_id' => $faker->numberBetween(1, 30),
                'date_affectation' => $faker->dateTimeBetween('-10 year', 'now'),
                'statut' => $faker->randomElement(['AFFECTE', 'RENDU', 'EN PANNE']),
                'chantier' => $faker->randomElement(['Chantier A', 'Chantier B', 'Chantier C', 'Bureau']),
                'utilisateur1' => $faker->name
            ]);
        }

        // Création des recrutements (30)
        for ($i = 0; $i < 30; $i++) {
            Recrutement::create([
                'nom' => $faker->name,
                'fonction' => $faker->jobTitle,
                'departement' => $faker->randomElement(['IT', 'RH', 'Finance', 'Marketing', 'Production']),
                'email' => $faker->email,
                'type_contrat' => $faker->randomElement(['CDI', 'CDD', 'Stage']),
                'telephone' => $faker->phoneNumber,
                'model' => $faker->randomElement(['iPhone 13', 'Samsung Galaxy S21', 'Google Pixel 6']),
                'num_serie' => 'SN' . $faker->unique()->numberBetween(10000, 99999),
                'puk' => $faker->numerify('########'),
                'pin' => $faker->numerify('####'),
                'date_affectation' => $faker->dateTimeBetween('-1 year', 'now'),
                'status' => $faker->randomElement(['en attente', 'validé', 'refusé'])
            ]);
        }

        // Création des notifications (30)
        for ($i = 0; $i < 30; $i++) {
            Notification::create([
                'recrutement_id' => $faker->numberBetween(1, 30),
                'type' => $faker->randomElement(['telephone', 'ordinateur', 'imprimante']),
                'etat' => $faker->randomElement(['Neuf', 'Bon état', 'À réparer']),
                'chantier' => $faker->randomElement(['Chantier A', 'Chantier B', 'Chantier C', 'Bureau']),
                'utilisateur' => $faker->name,
                'is_read' => $faker->boolean
            ]);
        }
    }
}
