<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomDesign extends Model
{
    protected $fillable = [
        'user_id',
        'style_id',
        'budget',
        'original_image_path',
        'generated_image_path',
        'status',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function style()
    {
        return $this->belongsTo(Style::class);
    }

    public function furnitureRecommendations()
    {
        return $this->hasMany(FurnitureRecommendation::class);
    }
}
