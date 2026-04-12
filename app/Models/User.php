<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'is_admin', 'mobile', 'google_id', 'apple_id', 'otp_code', 'otp_expires_at', 'otp_verified_at'])]
#[Hidden(['password', 'remember_token', 'otp_code'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_admin' => 'boolean',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
            'otp_verified_at' => 'datetime',
        ];
    }

    public function roomDesigns(): HasMany
    {
        return $this->hasMany(RoomDesign::class);
    }
}
