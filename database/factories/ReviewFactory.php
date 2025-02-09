<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
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
            'book_id' => null,
            'review' => fake()->paragraph(),
            'rating' => fake()->numberBetween(int1: 1, int2: 5),
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
    }

    public function good(): ReviewFactory
    {
        return $this->state(state: function (array $attributes): array {
            return [
                'rating' => fake()->numberBetween(int1: 4, int2: 5)
            ];
        });
    }

    public function average(): ReviewFactory
    {
        return $this->state(state: function (array $attributes): array {
            return [
                'rating' => fake()->numberBetween(int1: 2, int2: 5)
            ];
        });
    }

    public function bad(): ReviewFactory
    {
        return $this->state(function (array $attributes): array {
            return [
                'rating' => fake()->numberBetween(int1: 1, int2: 3)
            ];
        });
    }
}
