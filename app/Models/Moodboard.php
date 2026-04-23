<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moodboard extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'style_id',
        'color_palette',
        'items',
    ];

    protected $casts = [
        'color_palette' => 'array',
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function style()
    {
        return $this->belongsTo(Style::class);
    }
}
