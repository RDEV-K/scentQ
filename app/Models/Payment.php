<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['data' => 'array'];
    static $STATUS_PENDING = 'pending';
    static $STATUS_SUCCESS = 'success';
    static $STATUS_FAILED = 'failed';

    function holder()
    {
        return $this->morphTo();
    }

    function gateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_id', 'id');
    }
}
