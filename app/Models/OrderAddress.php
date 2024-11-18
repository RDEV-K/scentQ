<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrderAddress extends Model
{
    use Notifiable;

    protected $guarded = ['id'];

    function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
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
