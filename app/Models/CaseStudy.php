<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    public const CATEGORIES = [
        'advisory' => 'Advisory Retainer',
        'project' => 'Custom Project',
        'institutional' => 'Institutional',
    ];

    protected $fillable = [
        'category',
        'sector',
        'title',
        'metric_value',
        'metric_label',
        'outcome',
        'year_range',
        'duration',
        'sort_order',
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}
