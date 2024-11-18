<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = ['id'];

    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    function getFormattedCountryAttribute()
    {
        return config('countries.' . $this->country);
    }

    function getFormattedStateAttribute()
    {
        return config('states.' . $this->country . '.' . $this->state);
    }
}
