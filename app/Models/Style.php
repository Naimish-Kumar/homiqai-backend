<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Style extends Model
{
    protected $fillable = [
        'name',
        'thumbnail_url',
        'prompt_prefix',
    ];

    public function roomDesigns()
    {
        return $this->hasMany(RoomDesign::class);
    }

    public function furnitureProducts(): BelongsToMany
    {
        return $this->belongsToMany(FurnitureProduct::class, 'furniture_product_style');
    }
}
