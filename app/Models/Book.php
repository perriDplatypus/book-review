<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    public function reviews(): HasMany
    {
        return $this->hasMany(related: Review::class);
    }

    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where(column: 'title', operator: 'LIKE', value: '%' . $title . '%');
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withCount(relations: [
            'reviews' => fn(Builder $q) => $this->dateRangeFilter(query: $q, from: $from, to: $to)
        ])->orderBy(column: 'reviews_count', direction: 'desc');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvg(relation: [
            'reviews' => fn(Builder $q) => $this->dateRangeFilter(query: $q, from: $from, to: $to)
        ], column: 'rating')->orderBy(column: 'reviews_avg_rating', direction: 'desc');
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null): void
    {
        if ($from && !$to) {
            $query->where(column: 'created_at', operator: '>=', value: $from);
        } elseif (!$from && $to) {
            $query->where(column: 'created_at', operator: '<=', value: $to);
        } elseif ($from && $to) {
            $query->whereBetween(column: 'created_at', values: [$from, $to]);
        }
    }
}
