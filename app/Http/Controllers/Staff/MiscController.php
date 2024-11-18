<?php

namespace App\Http\Controllers\Staff;

use App\Models\Meta;
use App\Models\Order;
use App\Models\Product;
use App\Models\Settings;
use App\Models\SocialLink;
use App\Models\Taxonomy;
use App\Models\Term;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MiscController
{
    function dashboard()
    {
        $data = [];
        // chart data for this month
        $ordersSummary = Order::query()
            ->selectRaw('SUM(`net_total`) as net_total, SUM(`gross_total`) as gross_total, SUM(`discount`) as discount')
            ->whereMonth('created_at', now()->month)
            ->first();

        $data['net_total'] = currencyConvert($ordersSummary->net_total);
        $data['gross_total'] = currencyConvert($ordersSummary->gross_total);
        $data['discount'] = currencyConvert($ordersSummary->discount);

        $total_sale = $ordersSummary->gross_total;

        $data['total_sale'] = $total_sale ? number_format($total_sale, config('misc.round')) : 0;

        $today_sale = Order::query()
            ->whereDate('orders.created_at', today())
            ->sum('gross_total');

        $data['today_sale'] = $today_sale ? number_format($today_sale, config('misc.round')) : 0;

        $total_orders = Order::query()
            ->selectRaw('COUNT(*) as total_orders, SUM(CASE WHEN MONTH(created_at) = :current_month THEN 1 ELSE 0 END) as new_orders', ['current_month' => now()->month])
            ->first();

        $data['t_orders'] = $total_orders->total_orders;
        $data['new_orders'] = $total_orders->new_orders;

        $statusCounts = Order::query()
            ->selectRaw('status, COUNT(*) as count')
            ->whereIn('status', [
                Order::$STATUS_PENDING,
                Order::$STATUS_PROCESSING,
                Order::$STATUS_IN_TRANSIT,
                Order::$STATUS_COMPLETED
            ])
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        $data['pending_orders'] = $statusCounts->get(Order::$STATUS_PENDING, 0);
        $data['processing_orders'] = $statusCounts->get(Order::$STATUS_PROCESSING, 0);
        $data['way_orders'] = $statusCounts->get(Order::$STATUS_IN_TRANSIT, 0);
        $data['completed_orders'] = $statusCounts->get(Order::$STATUS_COMPLETED, 0);

        $data['total_customers'] = User::query()->where('is_active', true)->count();

        return view('staff.dashboard', $data);
    }

    function select2Data(Request $request)
    {
        $allowedModels = ['product' => Product::class];
        if (array_key_exists($request->model, $allowedModels)) {
            if ($request->model === 'product') {
                $q = Product::query()->select(['id', 'title', 'type']);
                if (in_array($request->type, Product::$types)) {
                    $q->where('type', $request->type);
                }
                if (in_array($request->type_not, Product::$types)) {
                    $q->whereNot('type', $request->type_not);
                }
                if (is_array($request->excludes)) {
                    $q->whereNotIn('id', $request->excludes);
                }
                return $q->get()->map(function (Product $product) {
                    return ['id' => $product->id, 'text' => $product->title, 'type' => $product->type];
                });
            }
        }
        return [];
    }

    function settings()
    {
        $social_links = SocialLink::orderBy('order', 'ASC')->get();
        // $case_subscription_price = Meta::getSetting('case_subscription_price', 0);
        $cashier_stripe_fragrance_subscription = getStripeProduct();
        $settings = Settings::first();
        return view('staff.setting.general', compact('social_links', 'cashier_stripe_fragrance_subscription', 'settings'));
    }

    function updateSettings(Request $request)
    {
        $request->validate([
            'cashier_stripe_fragrance_subscription' => 'required',
        ]);

        try {
            DB::beginTransaction();
            // foreach ($request->metas as $key => $value) {
                if(request()->getHost() == "scentq.co.uk") {
                    $exist = Meta::where('name', 'cashier_stripe_fragrance_subscription_for_uk')->first();
                    if(!$exist){
                        Meta::create([
                            'holder_type' => null,
                            'holder_id' => null,
                            'name' => 'cashier_stripe_fragrance_subscription_for_uk',
                            'content' => $request->cashier_stripe_fragrance_subscription,
                        ]);
                    }else{
                        $exist->update([
                            'content' => $request->cashier_stripe_fragrance_subscription,
                        ]);
                    }
                }else{
                    $exist = Meta::where('name', 'cashier_stripe_fragrance_subscription')->first();
                    if(!$exist){
                        Meta::create([
                            'holder_type' => null,
                            'holder_id' => null,
                            'name' => 'cashier_stripe_fragrance_subscription',
                            'content' => $request->cashier_stripe_fragrance_subscription,
                        ]);
                    }else{
                        $exist->update([
                            'content' => $request->cashier_stripe_fragrance_subscription,
                        ]);
                    }
                }

                $settings = Settings::first();
                $settings->update([
                    'azn_rate' => $request->azn_rate ?? 1.70,
                    'sar_rate' => $request->sar_rate ?? 3.75,
                    'kwd_rate' => $request->kwd_rate ?? 0.31,
                    'aed_rate' => $request->aed_rate ?? 3.67,
                    'bhd_rate' => $request->bhd_rate ?? 0.38,
                    'qar_rate' => $request->qar_rate ?? 3.64,
                    'pound_rate' => $request->pound_rate ?? 0.79,
                ]);

            // }
            DB::commit();
            return redirect()->back()->withSuccess('Updated successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    function profile()
    {
        $user = Auth::guard('staff')->user();
        return view('staff.profile', compact('user'));
    }

    function updateProfile(Request $request)
    {
        /* @var Staff $user */
        $user = Auth::user();
        $request->validate([
            'name' => 'required|max:191',
            'email' => 'required|max:191|email|unique:staff,email,' . $user->id,
            'username' => 'required|max:191' . $user->id,
            'password' => 'nullable|min:8|confirmed'
        ]);
        $p = $request->only(['name', 'email', 'phone', 'avatar']);
        if ($request->password) {
            $p['password'] = Hash::make($request->password);
        }
        try {
            $r = $user->update($p);
            if (!$r) throw new \Exception('Unable to update profile');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
        return redirect()->back()->withSuccess('Profile updated successfully');
    }
}
