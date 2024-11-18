<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    public $timestamps = false;
    private static $autoloadOptions;
    protected $guarded = ['id'];

    function holder()
    {
        return $this->morphTo();
    }

    static function getSetting($key, $default = null, $json = false)
    {
        if (!is_array(self::$autoloadOptions)) {
            self::$autoloadOptions = self::query()->whereNull('holder_type')->whereNull('holder_id')->pluck('content', 'name')->toArray();
        }
        if (!isset(self::$autoloadOptions[$key])) return $default;
        if ($json) return json_decode(self::$autoloadOptions[$key], true);
        return self::$autoloadOptions[$key];
    }
}
