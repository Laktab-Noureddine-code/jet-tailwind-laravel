<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Chemin vers le fichier CSV
        $csvPath = storage_path('app/data.csv');

        // Lire le fichier CSV
        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setDelimiter(';'); // Définir le délimiteur comme point-virgule
        $csv->setHeaderOffset(0); // La première ligne contient les en-têtes

        // Parcourir chaque ligne du CSV
        foreach ($csv as $record) {
            // Insérer l'utilisateur
            $utilisateurId = DB::table('utilisateurs')->insertGetId([
                'nom' => $record['nom'],
                'fonction' => $record['fonction'],
                'telephone' => $record['telephone'],
                'email' => $record['email'],
                'departement' => $record['departement'],
            ]);

            // Insérer le matériel
            $materielId = DB::table('materiels')->insertGetId([
                'fabricant' => $record['fabricant'],
                'type' => $record['type'],
                'etat' => $record['etat'],
                'num_serie' => $record['num_serie'],
                'statut' => $record['statut'],

            ]);

            // Insérer l'affectation
            DB::table('affectations')->insert([
                'materiel_id' => $materielId,
                'utilisateur_id' => $utilisateurId,
                'date_affectation' => $record['date_affectation'],
                'chantier' => $record['Chantier'],
            ]);
        }

        
    }

    
    
}
