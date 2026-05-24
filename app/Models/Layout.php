<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Layout extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'floor_plan_url',
        'result_3d_url',
        'status',
        'project_id',
        'items',
        'total_price',
        'wall_color',
        'floor_color',
        'floor_material',
        'ceiling_color',
        'saved_palettes',
    ];

    protected $casts = [
        'items' => 'array',
        'saved_palettes' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
