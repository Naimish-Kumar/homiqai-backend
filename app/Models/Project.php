<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
        'budget_limit',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function roomDesigns(): HasMany
    {
        return $this->hasMany(RoomDesign::class);
    }

    public function moodboards(): HasMany
    {
        return $this->hasMany(Moodboard::class);
    }

    public function layouts(): HasMany
    {
        return $this->hasMany(Layout::class);
    }
}
