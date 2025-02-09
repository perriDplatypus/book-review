<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // generate books with good reviews
        Book::factory(count: 33)->create()->each(function ($book): void {
            $numReviews = random_int(min: 5, max: 30);
            Review::factory()->count($numReviews)->good()->for($book)->create();
        });

        // generate books with average reviews
        Book::factory(count: 33)->create()->each(function ($book): void {
            $numReviews = random_int(min: 5, max: 30);
            Review::factory()->count($numReviews)->average()->for($book)->create();
        });

        // generate books with bad reviews
        Book::factory(count: 34)->create()->each(function ($book): void {
            $numReviews = random_int(min: 5, max: 30);
            Review::factory()->count($numReviews)->bad()->for($book)->create();
        });
    }
}
