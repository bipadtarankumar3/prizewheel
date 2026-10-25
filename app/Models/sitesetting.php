<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sitesetting extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    /**
     * Get a setting value for a user by key, with default fallback
     */
    public static function getSetting($userId, $key, $default = null)
    {
        $setting = self::where('user_id', $userId)->where('key', $key)->first();
        if ($setting && $setting->value !== null && $setting->value !== '') {
            return $setting->value;
        }
        return $default;
    }

    /**
     * Set/update a setting value for a user
     */
    public static function setSetting($userId, $key, $value)
    {
        return self::updateOrCreate(
            [
                'user_id' => (string)$userId,
                'key' => $key,
            ],
            [
                'value' => $value,
            ]
        );
    }

    /**
     * Get all key-value settings for a user as an associative array
     */
    public static function getAllSettings($userId)
    {
        return self::where('user_id', $userId)
            ->whereNotNull('key')
            ->pluck('value', 'key')
            ->toArray();
    }
}
