<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    /**
     * Establishes one to many foreign key relationship with reviews 
     * @return HasMany<Review, Book>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(related: Review::class);
    }

    /**
     * Query builder for searching by title
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $title
     * @return Builder
     */
    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where(column: 'title', operator: 'LIKE', value: '%' . $title . '%');
    }

    /**
     * Query builder for searching by popular books 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $from
     * @param mixed $to
     * @return Builder
     */
    public function scopePopular(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withCount(relations: [
            'reviews' => fn(Builder $q) => $this->dateRangeFilter(query: $q, from: $from, to: $to)
        ])->orderBy(column: 'reviews_count', direction: 'desc');
    }

    /**
     * Query builder for searching by highest rated books
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $from
     * @param mixed $to
     * @return Builder
     */
    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvg(relation: [
            'reviews' => fn(Builder $q) => $this->dateRangeFilter(query: $q, from: $from, to: $to)
        ], column: 'rating')->orderBy(column: 'reviews_avg_rating', direction: 'desc');
    }

    /**
     * Query builder to limit results to more than a minimum number of reviews
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $minReviews
     * @return Builder
     */
    public function scopeMinReviews(Builder $query, int $minReviews): Builder
    {
        return $query->having(column: 'reviews_count', operator: '>=', value: $minReviews);
    }

    /**
     * Helper function for applying date filters
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $from
     * @param mixed $to
     * @return void
     */
    private function dateRangeFilter(Builder $query, $from = null, $to = null): void
    {
        if ($from && !$to) {
            $query->where(column: 'created_at', operator: '>=', value: $from);
        } elseif (!$from && $to) {
            $query->where(column: 'created_at', operator: '<=', value: $to);
        } elseif ($from && $to) {
            $query->whereBetween(column: 'created_at', values: [$from, $to]);
        } else {
            return;
        }
    }
}
