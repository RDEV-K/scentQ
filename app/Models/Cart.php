<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];
    protected $appends = ['subscribe_items'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = $this->getPrimaryDatabase();
    }

    protected function getPrimaryDatabase(): string
    {
        // this system only applies for the UK domain

        $domain = getCurrentDomain();
        $database = 'mysql';

        // If it is scentq.co.uk
        if ($domain === 'scentq.co.uk') {
            $database = 'mysql_primary';
        }

        return $database ?? 'mysql';
    }

    function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id');
    }

    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }

    function getSubscribeItemsAttribute()
    {
        return $this->items->where('purchase_option_type', 'subscription')->count();
    }
}
