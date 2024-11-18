<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $guarded = ['id'];

    protected $casts =[
        'features' => 'array'
    ];

    public function autoCoupon()
    {
        return $this->belongsTo(Coupon::class, 'first_time_coupon_id', 'id');
    }

    public function freeProduct() {
        return $this->belongsTo(Product::class, 'free_product_id', 'id');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', 1);
    }

    public function scopePersonal($query)
    {
        return $query->where('type', 'personal');
    }

    public function scopeDomain($query, ...$domain)
    {
        return $query->where('domain', ...$domain);
    }

}
