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
use Illuminate\Database\Eloquent\Casts\Attribute;

#[Fillable(['name', 'email', 'profile', 'password', 'is_admin', 'mobile', 'google_id', 'apple_id', 'otp_code', 'otp_expires_at', 'otp_verified_at', 'fcm_id', 'free_designs_left', 'is_premium', 'is_blocked'])]
#[Hidden(['password', 'remember_token', 'otp_code', 'fcm_id'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['photo_url', 'phone_number'];

    /**
     * Get the user's profile photo URL.
     */
    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->profile ? url('storage/' . $this->profile) : null,
        );
    }

    /**
     * Get the user's phone number (alias for mobile).
     */
    protected function phoneNumber(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->mobile,
        );
    }

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
            'is_blocked' => 'boolean',
            'is_premium' => 'boolean',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
            'otp_verified_at' => 'datetime',
        ];
    }

    /**
     * Determine if the user has an active premium subscription.
     */
    public function getIsPremiumAttribute($value)
    {
        // If explicitly set to true, check if it's still valid
        if ($value) {
            $hasActiveSub = $this->subscriptions()
                ->where('status', 'active')
                ->where('end_date', '>', now())
                ->exists();
            
            if (!$hasActiveSub) {
                // If no active subscription found, update the cached value
                $this->update(['is_premium' => false]);
                return false;
            }
            return true;
        }
        return false;
    }

    public function roomDesigns(): HasMany
    {
        return $this->hasMany(RoomDesign::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function moodboards(): HasMany
    {
        return $this->hasMany(Moodboard::class);
    }

    public function layouts(): HasMany
    {
        return $this->hasMany(Layout::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
