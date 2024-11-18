<?php

namespace app\Services;

use Carbon\Carbon;
use App\Models\Coupon;
use Laravel\Cashier\Cashier;

class CouponService
{
    public function fiftyPercentOffCoupon(): void
    {
        // check 50 Off Coupon is exist
        $coupon = Coupon::create([
            'code' => '50% Off',
            'start_at' => Carbon::parse(Carbon::now()->startOfYear())->format('Y-m-d'),
            'expire_at' => Carbon::parse(Carbon::now()->endOfYear())->format('Y-m-d'),
            'min' => '-1',
            'upto' => '-1',
            'discount_type' => 1,
            'amount' => 50,
            'maximum_use_limit' => '0',
            'emails' => '0',
            'domain' => getCurrentDomain(),
        ]);

        $cashierCouponParams = [
            'currency' => config('misc.currency_code'),
            'name' => $coupon->code
        ];
        if ($coupon->maximum_use_limit && $coupon->maximum_use_limit >= 1) {
            $cashierCouponParams['max_redemptions'] = $coupon->maximum_use_limit;
        }
        if ($coupon->discount_type == 1) {
            $cashierCouponParams['percent_off'] = $coupon->amount;
        } else {
            $cashierCouponParams['amount_off'] = ($coupon->amount * 100);
        }
        $stripeCoupon = Cashier::stripe()->coupons->create($cashierCouponParams);
        $coupon->update([
            'strip_coupon' => $stripeCoupon->id
        ]);
    }

    public function resubscriptionCoupon(): void
    {
        // check Resubscription Coupon is exist
        $coupon = Coupon::create([
            'code' => 'Resubscription',
            'start_at' => Carbon::parse(Carbon::now()->startOfYear())->format('Y-m-d'),
            'expire_at' => Carbon::parse(Carbon::now()->endOfYear())->format('Y-m-d'),
            'min' => '-1',
            'upto' => '-1',
            'discount_type' => 2,
            'amount' => 9.99,
            'maximum_use_limit' => '0',
            'emails' => '0',
            'domain' => getCurrentDomain(),
        ]);

        $cashierCouponParams = [
            'currency' => config('misc.currency_code'),
            'name' => $coupon->code
        ];
        if ($coupon->maximum_use_limit && $coupon->maximum_use_limit >= 1) {
            $cashierCouponParams['max_redemptions'] = $coupon->maximum_use_limit;
        }
        if ($coupon->discount_type == 1) {
            $cashierCouponParams['percent_off'] = $coupon->amount;
        } else {
            $cashierCouponParams['amount_off'] = ($coupon->amount * 100);
        }
        $stripeCoupon = Cashier::stripe()->coupons->create($cashierCouponParams);
        $coupon->update([
            'strip_coupon' => $stripeCoupon->id
        ]);
    }
}
