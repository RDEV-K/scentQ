<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Cashier;

class FirstMonthDiscountController extends Controller
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $setting;

    public function __construct()
    {
        $this->setting = Settings::first();
    }

    public function index()
    {
        $setting = Settings::first();

        return view('staff.discount.first-month-discount', compact('setting'));
    }

    public function update(Request $request)
    {
        try{

            DB::beginTransaction();
            $request->validate([
                'percentage' => 'required|min:1|numeric'
            ]);

            $this->setting->update([
                "first_month_subscribe_discount_percentage" => $request->percentage,
                "first_month_subscribe_discount_status" => $request->enable ? true : false
            ]);

            $exitCoupon = Coupon::where('code','!=','50% Off')->where('maximum_use_limit','-1')->where('start_at',null)->where('expire_at',null)->first();
            if($exitCoupon){
                $data['code'] = $request->percentage;
                $data['amount'] = $request->percentage;
                $stripeCouponDelete = Cashier::stripe()->coupons->delete($exitCoupon->strip_coupon,[]);

                $cashierCouponParams = [
                    'currency' => config('misc.currency_code'),
                    'name' => $request->percentage,
                    'amount_off' => ($request->percentage * 100)
                ];
                $stripeCoupon = Cashier::stripe()->coupons->create($cashierCouponParams);
                $data['strip_coupon'] = $stripeCoupon->id;
                $coupon = $exitCoupon->update($data);

            } else{

                $data['domain'] = getCurrentDomain();
                $data['amount'] = $request->percentage;
                $data['discount_type'] = 2;
                $data['code'] = $request->percentage;
                $coupon = Coupon::create($data);

                $cashierCouponParams = [
                    'currency' => config('misc.currency_code'),
                    'name' => $coupon->code,
                    'amount_off' => ($coupon->amount * 100)
                ];

                $stripeCoupon = Cashier::stripe()->coupons->create($cashierCouponParams);
                $coupon->update([
                    'strip_coupon' => $stripeCoupon->id
                ]);
            }
            DB::commit();
            return redirect()->back();

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
}
