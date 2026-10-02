<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructuralProfile extends Model
{
    use HasFactory;

    public const TYPES = [
        'IWF' => 'IWF / WF (H-Beam)',
        'UNP' => 'UNP (Channel)',
    ];

    protected $fillable = ['type', 'size', 'weight_per_m'];

    protected function casts(): array
    {
        return [
            'weight_per_m' => 'float',
        ];
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type)->orderBy('weight_per_m');
    }

    public function getLabelAttribute(): string
    {
        return $this->type.' - '.$this->size.' ('.number_format($this->weight_per_m, 2, ',', '').' kg/m)';
    }
}
