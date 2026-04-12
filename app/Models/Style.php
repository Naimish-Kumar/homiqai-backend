<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
