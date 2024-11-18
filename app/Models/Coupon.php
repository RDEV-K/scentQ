<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Coupon extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['emails' => 'array'];
    protected $dates = ['start_at', 'expire_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_coupon');
    }

    public function ref()
    {
        return $this->morphTo();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_coupon');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'coupon_id', 'id');
    }

    public function getUsedAttribute($val)
    {
        return $this->orders()->count();
    }

    public function getStatusAttribute($val)
    {
        if (Carbon::now()->between($this->start_at, $this->expire_at)) return 1;
        if (Carbon::now()->lt($this->start_at)) return 2;
        return 0;
    }

    public function isValid($filters = [])
    {
        if ($this->system_added) {
            if ($this->redeemed) throw ValidationException::withMessages(['code' => 'Invalid Coupon']);
        } else {
            if (!Carbon::now()->between($this->start_at, $this->expire_at)) {
                throw ValidationException::withMessages(['code' => 'Coupon expired']);
            }
        }

        if ($this->maximum_use_limit != -1) {
            $query = $this->orders();
            if (isset($filters['user_id'])) {
                $query->where('user_id', $filters['user_id']);
            }
            $used_by_current_user = $query->count();
            if ($this->maximum_use_limit <= $used_by_current_user) {
                throw ValidationException::withMessages(['code' => 'Maximum use limit existed']);
            }
        }

        if ($this->min != -1 && isset($filters['total'])) {
            if ($filters['total'] < $this->min) {
                throw ValidationException::withMessages(['code' => 'Not enough amount for this coupon']);
            }
        }

        if (isset($filters['cart']) && $filters['cart'] instanceof Cart) {
            $productIds = $this->products()->pluck('products.id');
            if ($productIds->count()) {
                $intersection = $filters['cart']->items->pluck('product_id')->intersect($productIds);
                if (!$intersection->count()) {
                    throw ValidationException::withMessages(['code' => 'Not eligible for this cart']);
                }
            }
        }

        if (isset($filters['email']) && is_array($this->emails)) {
            if (!in_array($filters['email'], $this->emails)) throw ValidationException::withMessages(['code' => 'You\'r not eligible for this coupon']);
        }

        if (isset($filters['user_id'])) {
            $userIds = $this->users()->pluck('users.id');
            if ($userIds->count()) {
                if (!$userIds->contains($filters['user_id'])) {
                    throw ValidationException::withMessages(['code' => 'You\'r not eligible for this coupon']);
                }
            }
        }

        if ($this->strip_coupon) {
            if (!isStripeCouponValid($this->strip_coupon)) {
                throw ValidationException::withMessages(['code' => 'Gateway coupon invalid']);
            }
        }

        return true;
    }

    public function scopeDomain($query, ...$domain)
    {
        return $query->where('domain', ...$domain);
    }
}
