<?php

namespace App\Http\Middleware;

use App\Models\Faq;
use Inertia\Middleware;
use App\Models\Settings;
use App\Models\QueueItem;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Http\Request;
use App\Services\SocialLinkService;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\CartItemController;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        // config()->set('misc.logo', asset(config('misc.logo')));
        // config()->set('misc.icon', asset(config('misc.icon')));
        // config()->set('misc.subscription_head_image', asset(config('misc.subscription_head_image')));

        $ziggy = new Ziggy($group = null, $request->url());
        $faqs = Cache::remember('latest_faq', now()->addWeeks(2), fn () => Faq::latest()->get(['question', 'answer']));
        $settings = Cache::remember('settings', now()->addWeeks(2), fn () => Settings::first());

        // auth user current month queue items
        $current_month_queue_items = [];


        /* @var  */
        $user = null;
        if (auth('web')->check()) {
            /* @var User $user */
            $user = $request->user();
            $month = date('n'); // current month
            $year = date('Y'); // current year

            try {
                $auth_user_queue = $user?->queues()
                    ->where('year', $year)
                    ->where('month', $month)
                    ->first();

                if (!$auth_user_queue) {
                    $auth_user_queue = $user->queues()->create([
                        'month' => $month,
                        'year' => $year
                    ]);
                }

                $current_month_queue_items = $auth_user_queue->items()->with(['product', 'product.brand'])->get() ?? [];
                // auth user current month queue items End
                $cart = $user->cart()
                    ->with([
                        'items',
                        'items.product',
                        'items.product.sub_type',
                        'items.product.brand',
                        'items.product.purchase_options'
                    ])
                    ->firstOrCreate();

                $cart->shipping = $request->routeIs('staff.*') ? '' : CartItemController::calculateShippingPolicy($user, ['total' => $cart->net_total]);

                $user->setRelation('cart', $cart);
                $user->append(['personal_subscription', 'case_subscription', 'referral_url']);

                $user = $user->toArray();

                $queueCount = QueueItem::query()
                    ->whereNotNull('addedBy_type')
                    ->whereHas('queue', fn ($q) => $q->where('user_id', $user['id'])->whereDoesntHave('order'))
                    ->count();
            } catch (\Throwable $th) {
                $queueCount = 0;
                if (session()->has('scentq_queue')) {
                    $ids = session()->get('scentq_queue', []);
                    $queueCount = is_array($ids) ? count($ids) : 0;
                }
            }
        } else {
            $queueCount = 0;
            if (session()->has('scentq_queue')) {
                $ids = session()->get('scentq_queue', []);
                $queueCount = is_array($ids) ? count($ids) : 0;
            }
        }

        return array_merge(parent::share($request), [
            // Add in Ziggy routes for SSR
            'ziggy' => $ziggy->toArray(),
            'user' => $user,
            'translations' => function () {
                return translations(
                    base_path('lang/' . config('misc.language') . '.json')
                );
            },
            'queueCount' => $queueCount,
            'current_month_queue_items' => $current_month_queue_items,
            'social_links' => SocialLinkService::getAllLinks(),
            'fiftyPercentOffAmount' => fiftyPercentOff(),
            'queue_session' => session()->has('scentq_queue'),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'status' => fn () => $request->session()->get('status'),
                'queue' => fn () => $request->session()->get('queue'),
                'queue_added' => fn () => $request->session()->get('queue_added'),
                'subscribed' => fn () => $request->session()->get('subscribed'),
                'success_alert' => fn () => $request->session()->get('success_alert'),
                'warning_alert' => fn () => $request->session()->get('warning_alert'),
            ],
            'faqs' => $faqs,
            'config' => [
                'app' => [
                    'name' => config('app.name'),
                    'azn_rate' => $settings?->azn_rate ?? 0,
                    'sar_rate' => $settings?->sar_rate ?? 0,
                    'kwd_rate' => $settings?->kwd_rate ?? 0,
                    'aed_rate' => $settings?->aed_rate ?? 0,
                    'bhd_rate' => $settings?->bhd_rate ?? 0,
                    'qar_rate' => $settings?->qar_rate ?? 0,
                    'pound_rate' => $settings?->pound_rate ?? 0,

                    'subscribe_discount_status' => $settings?->first_month_subscribe_discount_status ?? false,
                    'subscribe_discount_amount' => $settings?->first_month_subscribe_discount_percentage ?? 0,
                ],
                'misc' => config('misc'),
                'scout' => [
                    'id' => config('scout.algolia.id'),
                    'key' => config('scout.algolia.search_only'),
                    'prefix' => config('scout.prefix'),
                ]
            ]
        ]);
    }
}
