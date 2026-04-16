<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'film_id' => \App\Models\Film::inRandomOrder()->value('id'),
            'user_id' => \App\Models\User::inRandomOrder()->value('id'),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'upvotes_count' => $this->faker->numberBetween(0, 100),
        ];
    }
}
