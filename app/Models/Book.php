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

    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount(relations: 'reviews')->orderBy(column: 'reviews_count', direction: 'desc');
    }

    public function scopeHighestRated(Builder $query): Builder
    {
        return $query->withAvg(relation: 'reviews', column: 'rating')->orderBy(column: 'reviews_avg_rating', direction: 'desc');
    }
}
