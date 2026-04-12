<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FurnitureRecommendation extends Model
{
    protected $fillable = [
        'room_design_id',
        'name',
        'price',
        'purchase_link',
        'image_url',
    ];

    public function roomDesign()
    {
        return $this->belongsTo(RoomDesign::class);
    }
}
