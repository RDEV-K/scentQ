<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueItem extends Model
{
    protected $guarded = ['id'];

    function queue()
    {
        return $this->belongsTo(Queue::class, 'queue_id', 'id');
    }

    function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
