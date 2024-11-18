<?php

namespace App\Http\Controllers\Staff;

use App\Http\Requests\Staff\CouponRequest;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use App\Services\Staff\CouponService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Cashier;

class CouponController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $table = CouponService::ajaxCall($request);

            return $table->make(true);
        }

        return view('staff.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = User::all();
        $products = Product::all();

        return view('staff.coupon.create',  compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        $data = $request->only(['code', 'start_at', 'expire_at', 'min', 'upto', 'discount_type', 'amount', 'maximum_use_limit', 'emails']);

        if ($request->start_at) {
            $data['start_at'] = Carbon::createFromFormat('d/m/Y', $request->start_at);
        }
        if ($request->expire_at) {
            $data['expire_at'] = Carbon::createFromFormat('d/m/Y', $request->expire_at);
        }
        if (!$request->min) {
            $data['min'] = -1;
        }
        if (!$request->maximum_use_limit) {
            $data['maximum_use_limit'] = -1;
        }
        if (!$request->upto) {
            $data['upto'] = -1;
        }

        $data['domain'] = getCurrentDomain();

        DB::beginTransaction();
        try {
            /** @var Coupon $coupon */
            $coupon = Coupon::create($data);
            if (!$coupon) throw new \Exception('Unable to create coupon');
            if (is_array($request->customers)) {
                $coupon->users()->attach($request->customers);
            }
            if (is_array($request->products)) {
                $coupon->products()->attach($request->products);
            }
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
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
        
        DB::commit();
        return redirect()->route('staff.coupon.index')->withSuccess('Coupon added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        if (!$coupon) return abort(404);
        if ($coupon->system_added) return abort(404);
        $customers = User::all();
        $products = Product::all();
        $coupon_users = $coupon->users()->pluck('user_id')->toArray();
        $coupon_products = $coupon->products()->pluck('product_id')->toArray();
        return view('staff.coupon.edit', compact('coupon', 'customers', 'products', 'coupon_users', 'coupon_products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        if (!$coupon) return abort(404);
        if ($coupon->system_added) return abort(404);
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'start_at' => 'required|date_format:"d/m/Y"',
            'expire_at' => 'required|date_format:"d/m/Y"',
            'customers.*' => 'nullable|exists:users,id',
            'products.*' => 'nullable|exists:products,id',
            'discount_type' => 'required|in:1,2',
            'amount' => 'required|numeric',
            'upto' => 'nullable|numeric',
            'maximum_use_limit' => 'nullable|numeric',
            'min' => 'nullable|numeric',
            'emails' => 'nullable|array',
            'emails.*' => 'required|email'
        ],  [
            'emails.*' => __('Please give a valid email address')
        ]);

        /** @var Coupon $coupon */
        $data = $request->only(['code', 'start_at', 'expire_at', 'min', 'upto', 'discount_type', 'amount', 'maximum_use_limit', 'emails']);

        if ($request->start_at) {
            $data['start_at'] = Carbon::createFromFormat('d/m/Y', $request->start_at);
        }
        if ($request->expire_at) {
            $data['expire_at'] = Carbon::createFromFormat('d/m/Y', $request->expire_at);
        }
        if (!$request->min) {
            $data['min'] = -1;
        }
        if (!$request->maximum_use_limit) {
            $data['maximum_use_limit'] = -1;
        }
        if (!$request->upto) {
            $data['upto'] = -1;
        }
        DB::beginTransaction();
        try {
            /** @var Coupon $coupon */
            $res = $coupon->update($data);
            $coupon->users()->detach();
            $coupon->products()->detach();
            if (!$res) throw new \Exception('Unable to Update coupon');
            if (is_array($request->customers)) {
                $coupon->users()->attach($request->customers);
            }
            if (is_array($request->products)) {
                $coupon->products()->attach($request->products);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            // return $exception;
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
        DB::commit();
        return redirect()->route('staff.coupon.index')->withSuccess('Coupon Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Coupon $coupon)
    {
        if (!$coupon) return abort(404);
        if ($coupon->system_added) return abort(404);

        $id = $coupon->strip_coupon;
        $coupon->delete();
        Cashier::stripe()->coupons->delete($id);

        return redirect()->back()->withSuccess(__('Coupon Successfully Deleted'));
    }
}
