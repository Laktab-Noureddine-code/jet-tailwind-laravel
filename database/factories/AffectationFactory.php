<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Affectation>
 */
class AffectationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'materiel_id' => \App\Models\Materiel::factory(),
            'utilisateur_id' => \App\Models\Utilisateur::factory(),
            'date_affectation' => $this->faker->date(),
            'utilisateur' => $this->faker->name(),
            'chantier' => $this->faker->company(),
        ];
    }
}
