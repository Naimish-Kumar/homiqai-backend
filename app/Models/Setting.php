<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Throwable;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'display_name',
        'description',
    ];

    public static function tableIsAvailable(): bool
    {
        try {
            return Schema::hasTable((new static())->getTable());
        } catch (Throwable) {
            return false;
        }
    }

    public static function safeKeyedValues(): Collection
    {
        if (! static::tableIsAvailable()) {
            return collect();
        }

        try {
            return static::query()->get()->keyBy('key');
        } catch (Throwable) {
            return collect();
        }
    }

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (! static::tableIsAvailable()) {
            return $default;
        }

        try {
            $setting = self::where('key', $key)->first();
        } catch (Throwable) {
            return $default;
        }

        if (!$setting) {
            return $default;
        }

        return self::castValue($setting->value, $setting->type);
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): self
    {
        if (! static::tableIsAvailable()) {
            throw new \RuntimeException('Settings table is not available.');
        }

        $type = gettype($value);
        if (is_array($value)) $type = 'json';
        if (is_bool($value)) $type = 'boolean';
        if (is_int($value)) $type = 'integer';

        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) ? json_encode($value) : (string) $value,
                'type' => $type,
                'group' => $group,
            ]
        );

        return $setting;
    }

    /**
     * Cast value based on type.
     */
    protected static function castValue(mixed $value, string $type): mixed
    {
        if (is_null($value)) return null;

        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'json' => json_decode($value, true),
            default => (string) $value,
        };
    }
}
