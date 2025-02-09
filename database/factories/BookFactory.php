<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $created_at = fake()->dateTimeBetween(startDate: '-2 years');
        $updated_at = fake()->dateTimeBetween(startDate: $created_at, endDate: 'now');
        return [
            'title' => fake()->sentence(nbWords: 3),
            'author' => fake()->name,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
    }
}
