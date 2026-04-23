<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FurnitureProduct extends Model
{
    protected $fillable = [
        'name',
        'category',
        'brand',
        'image_url',
        'affiliate_link',
        'low_price',
        'medium_price',
        'high_price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'low_price' => 'decimal:2',
        'medium_price' => 'decimal:2',
        'high_price' => 'decimal:2',
    ];

    public function styles(): BelongsToMany
    {
        return $this->belongsToMany(Style::class, 'furniture_product_style');
    }

    public function priceForBudget(string $budget): ?float
    {
        return match ($budget) {
            'low' => $this->low_price ? (float) $this->low_price : null,
            'high' => $this->high_price ? (float) $this->high_price : null,
            default => $this->medium_price ? (float) $this->medium_price : null,
        };
    }
}
