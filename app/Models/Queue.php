<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Queue extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['month_name'];

    function items()
    {
        return $this->hasMany(QueueItem::class, 'queue_id', 'id');
    }

    function order()
    {
        return $this->hasOne(Order::class, 'queue_id', 'id');
    }

    function getMonthNameAttribute()
    {
        $month = $this->month;
        $dateObj   = DateTime::createFromFormat('!m', $month);
        $current_full_month = $dateObj->format('F');

        return $current_full_month ?? '';
    }
}
