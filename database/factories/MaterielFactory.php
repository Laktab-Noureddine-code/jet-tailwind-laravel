<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Materiel>
 */
class MaterielFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['PC Portable', 'PC Bureau', 'Imprimante', 'Routeur', 'Disque Externe']);
        dump("Type généré : " . $type); // Afficher la valeur insérée
        return [
            'fabricant' => $this->faker->company,
            'type' => $this->faker->randomElement(['PC Portable', 'PC Bureau', 'Imprimante', 'Routeur', 'Disque Externe']),
            'etat' => $this->faker->randomElement(['Neuf', 'Occasion']),
            'num_serie' => $this->faker->bothify('???###'),
            'statut' => 'AFFECTE',
        ];
    }
}
