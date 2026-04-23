<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $fillable = [
        'user_id',
        'method',
        'url',
        'payload',
        'response',
        'status_code',
        'duration_ms',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'payload' => 'array',
        'response' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
