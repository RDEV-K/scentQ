<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class PlanService
{
    public function __construct()
    {
    }

    /**
     * Get Plan first default plan
     * @return Plan
     */
    public static function getDefaultPlan()
    {
        return Cache::remember(
            'default_plan',
            now()->addWeek(),
            fn () => Plan::default()->domain(getCurrentDomain())->first()
        );
    }

    /**
     * Get Current default plan
     * @return Plan
     */
    public static function getCurrentDefaultPlan()
    {
        return Cache::remember(
            'current_plan',
            now()->addWeek(),
            fn () => Plan::personal()
                ->default()
                ->domain(getCurrentDomain())
                ->first()
        );
    }

    /**
     * Get personal plans ordered by product count
     * @return Collection|Plan[]
     */
    public static function getPersonalPlansOrderByProductCount()
    {
        return Cache::remember(
            'personal_plan_product_count',
            now()->addWeek(),
            fn () => Plan::personal()
                ->orderBy('product_count', 'asc')
                ->domain(getCurrentDomain())
                ->get()
        );
    }

    /**
     * Get default first plan with Coupon and Free Products
     * @return Collection|Plan[]
     */

    public static function getPlanWithCouponAndFreeProduct()
    {
        return Cache::remember(
            'plans_with_coupon_and_free_product',
            now()->addWeek(),
            fn () => Plan::query()
                ->with(['autoCoupon', 'freeProduct'])
                ->default()
                ->domain(getCurrentDomain())
                ->first()
        );
    }
}
