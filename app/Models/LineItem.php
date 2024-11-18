<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineItem extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['attrs' => 'array'];
    protected $appends = ['brand_name'];

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

    function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    function getBrandNameAttribute()
    {
        $product = $this->product?->brand;
        return $product?->name;
    }

    public function metas()
    {
        return $this->morphMany(Meta::class, 'holder');
    }
}
