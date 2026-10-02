<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'logam-ferro' => 'Logam Ferro (Besi & Baja)',
        'logam-non-ferro' => 'Logam Non-Ferro',
        'non-logam' => 'Non-Logam',
    ];

    protected $fillable = [
        'name',
        'slug',
        'category',
        'density_kg_m3',
        'price_per_kg',
        'image',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'density_kg_m3' => 'float',
            'price_per_kg' => 'float',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}
