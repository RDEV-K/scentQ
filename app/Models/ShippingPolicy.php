<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingPolicy extends Model
{
    protected $guarded = ['id'];

    function metas()
    {
        return $this->morphMany(Meta::class, 'holder');
    }
}
