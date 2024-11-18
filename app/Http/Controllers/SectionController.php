<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\Note;
use App\Models\Plan;
use App\Models\User;
use App\Models\Product;
use App\Models\CardStyle;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Services\PlanService;
use Illuminate\Support\Facades\Cache;

class SectionController extends Controller
{
    function sectionData(Request $request, $section)
    {
        if (!method_exists($this, $section)) return abort(404);
        return $this->{$section}($request);
    }

    function userRefCount(Request $request)
    {
        /* @var User $user */
        $user = $request->user('web');
        return $user->referres()->count();
    }

    function QueueShipment(Request $request)
    {
        /* @var User $user */
        $user = $request->user();
        $shipping = $user->addresses()->where('type', 'shipping')->first();
        $month = date('n');
        $year = date('Y');
        if ($month == 1) {
            $month = 12;
            $year = $year - 1;
        } else {
            $month--;
        }
        $calculatedYear = $year + ($month / 12);
        $queues = $user->queues()->with(['order', 'items' => function ($q) {
            $q->with(['product' => function ($q2) {
                $q2->with('brand');
            }]);
        }])->whereHas('items')->whereRaw($calculatedYear . ' <= (year+(month/12))')->take(3)->get();
        $shipping?->append('formatted_state');
        return response()->json(compact('shipping', 'queues'));
    }

    function queuesByYear(Request $request)
    {
        $user = $request->user();
        $currentMonth = date('n');
        $currentYear = date('Y');

        $previousMonth = $currentMonth - 1;
        $previousYear = $currentYear;

        if ($previousMonth == 0) {
            $previousMonth = 12;
            $previousYear--;
        }

        $queues = $user->queues()
            ->with(['order', 'items.product.brand'])
            ->where('year', $currentYear)
            ->where(function ($query) use ($previousYear, $previousMonth) {
                $query->where('year', '>', $previousYear)
                    ->orWhere(function ($query) use ($previousYear, $previousMonth) {
                        $query->where('year', $previousYear)
                            ->where('month', '>=', $previousMonth);
                    });
            })
            ->whereHas('items', function ($query) {
                $query->whereNotNull('addedBy_type');
            })
            ->get();

        return $queues->groupBy('year');
    }


    function personalPlans(Request $request)
    {
        /* @var User $user */
        $user = $request->user();
        $plans = Plan::query()->where('type', 'personal')->domain(getCurrentDomain())->get();
        $myPersonalSubscriptionPrice = $user->subscription('personal')?->stripe_price;
        return response()->json(compact('plans', 'myPersonalSubscriptionPrice'));
    }


    function getCollection(Request $request)
    {
        $q = Collection::query()->where('type', $request->type);
        if ($request->for) {
            $q->where('for', $request->for);
        }
        if ($request->except && is_array($request->except)) {
            $q->whereNotIn('id', $request->except);
        }
        return $q->get();
    }

    public function getAllProductCards()
    {
        $products = Product::with(['labels', 'brand', 'notes', 'badges'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rate')
            ->where('status', 'published')
            ->get();
        return response()->json(compact('products'));
    }

    public function getGiftPlans($type)
    {
        $giftPlan = Plan::query()->where('type', $type->type)->domain(getCurrentDomain())->get();
        return $giftPlan;
    }

    public function getGiftSets(Request $request)
    {
        $giftSet = Product::with(['gift_products' => function ($q) {
            $q->with(['product' => function ($q2) {
                $q2->with('brand');
            }]);
        }])->where('type', 'giftset')->where('for', $request->for)->get();
        return $giftSet;
    }

    public function getTrendingNotes()
    {
        $trendingNotes = Cache::remember(
            'trending_notes',
            now()->addHours(12),
            fn()=>Note::whereHas('products')->withCount('products')->limit(18)->get()
        );

        return $trendingNotes;
    }

    public function footer(): array
    {
        $results = [];
        $results['plan'] = PlanService::getDefaultPlan();
        // $results['socials'] = Meta::getSetting('social_links', [], true);
        $results['socials'] = [];
        return $results;
    }
}
