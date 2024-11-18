<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['attrs' => 'array'];

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

    function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

    function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    function purchase_option()
    {
        return $this->belongsTo(PurchaseOption::class, 'purchase_option_id', 'id');
    }

    function queue_item()
    {
        return $this->belongsTo(QueueItem::class, 'queue_item_id', 'id');
    }
}
