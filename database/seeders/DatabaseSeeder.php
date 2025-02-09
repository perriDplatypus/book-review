<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // generate books with good reviews
        Book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);
            Review::factory()->count($numReviews)->good()->for($book)->create();
        });

        // generate books with average reviews
        Book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);
            Review::factory()->count($numReviews)->average()->for($book)->create();
        });

        // generate books with bad reviews
        Book::factory(34)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);
            Review::factory()->count($numReviews)->bad()->for($book)->create();
        });
    }
}
