<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomDesign extends Model
{
    protected $fillable = [
        'user_id',
        'style_id',
        'room_type',
        'budget',
        'original_image_path',
        'generated_image_path',
        'status',
        'is_favorite',
        'metadata',
        'project_id',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_favorite' => 'boolean',
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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
