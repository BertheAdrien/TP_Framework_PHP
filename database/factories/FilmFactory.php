<?php

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement([
                'Le Dernier Royaume',
                'L’Ombre de la Nuit',
                'Rêves Brisés',
                'La Renaissance du Phénix',
                'Guerre Éternelle',
                'Le Chemin Silencieux',
                'Horizon Sombre',
                'Perdu dans le Temps',
                'Ciel Pourpre',
                'La Mission Finale',
                'Les Larmes du Destin',
                'La Nuit des Ombres',
                'Le Souffle du Dragon',
                'Au-delà des Étoiles',
                'Le Dernier Espoir',
            ]),
            'release_year' => $this->faker->year,
            'synopsis' => $this->faker->paragraph,
        ];
    }
}
