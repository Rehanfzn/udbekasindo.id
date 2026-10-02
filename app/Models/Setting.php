<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @var array<string, string|null> */
    protected static array $cache = [];

    protected $fillable = ['key', 'value'];

    protected function casts(): array
    {
        return [
            'value' => 'string',
        ];
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        if (! array_key_exists($key, self::$cache)) {
            $setting = static::query()->where('key', $key)->first();
            self::$cache[$key] = $setting?->value;
        }

        return self::$cache[$key] ?? $default;
    }

    public static function set(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        self::$cache[$key] = $value;
    }

    /** @return array<string, string|null> */
    public static function allMap(): array
    {
        if (self::$cache === []) {
            foreach (static::query()->pluck('value', 'key') as $key => $value) {
                self::$cache[$key] = $value;
            }
        }

        return self::$cache;
    }

    public static function flush(): void
    {
        self::$cache = [];
    }
}
