<?php
namespace App\Helpers;

use Illuminate\Support\Str;

trait MenuAble
{
    static function getLabel()
    {
        return (new \ReflectionClass(self::class))->getShortName();
    }

    function getItemId()
    {
        return Str::slug(self::getLabel()) . '-' . $this->id;
    }

    function getItemText()
    {
        return $this->name;
    }

    function getItemUrl()
    {
        return route('category', $this->slug);
    }

    static function menurecords()
    {
        return self::all();
    }
}
