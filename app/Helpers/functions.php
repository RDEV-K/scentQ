<?php

use App\Models\Meta;
use App\Models\Plan;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use msztorc\LaravelEnv\Env;
use App\Services\PlanService;
use Torann\GeoIP\Facades\GeoIP;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

function inertiaWithMeta(\App\Models\Page|\App\Models\Product $page, $data = []): \Inertia\Response
{
    $metas = $page->metas->pluck('content', 'name')->toArray();
    $title = isset($metas['og_title']) ? $metas['og_title'] : $page->title;
    $keywords = isset($metas['og_keywords']) ? $metas['og_keywords'] : str_replace(' ', ',', $page->title);
    $description = isset($metas['og_description']) ? $metas['og_description'] : strip_tags($page->content);
    $image = isset($metas['og_image']) ? $metas['og_image'] : $page->image;

    if (isset($metas['og_image'])) {
        $image = $metas['og_image'];
    } elseif (is_array($page->images)) {
        $images = array_filter($page->images, function ($im) {
            return isset($im['type']) && $im['type'] == 'image';
        });
        if (isset($images[0])) $image = $images[0]['url'];
    } else {
        $image = $page->image;
    }

    $data['page'] = $page;
    $data['sections'] = $page->sections ?? [];

    if ($page instanceof \App\Models\Product) {
        $template = 'Product';
    } else {
        $template = $page->template;
    }


    return inertia($template, $data)
        ->title($page->title)
        ->description($description ?? '')
        ->image($image ?? '')
        ->ogTitle($title)
        ->ogMeta()
        ->twitterSummaryCard()
        ->head('<meta name="keywords" content="' . $keywords . '">');
}

function isStripeCouponValid($coupon): bool|\Stripe\Coupon
{
    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    try {
        $coupon = \Stripe\Coupon::retrieve($coupon);
        if ($coupon->valid) return $coupon;
        return false;
    } catch (\Exception $e) {
        return false;
    }
}

function currencyConvert($price = 0)
{
    return numberFormat($price);
    // if (config('misc.currency_code') == 'AZN') {
    //     $setting = Settings::first();
    //     $azn_rate = $setting?->azn_rate;
    //     $converted_rate = floatval($price) * floatval($azn_rate);
    //     return numberFormat($converted_rate);
    // } elseif (config('misc.currency_code') == 'SAR') {
    //     $setting = Settings::first();
    //     $sar_rate = $setting?->sar_rate;
    //     $converted_rate = floatval($price) * floatval($sar_rate);
    //     return numberFormat($converted_rate);
    // } elseif (config('misc.currency_code') == 'GBP') {
    //     $setting = Settings::first();
    //     $pound_rate = $setting?->pound_rate;
    //     $converted_rate = floatval($price) * floatval($pound_rate);
    //     return numberFormat($converted_rate);
    // } else {
    //     return numberFormat($price);
    // }
}

function currencyConvertWithSymbol($price = 0)
{
    return setSymbol(numberFormat($price));
    // if (config('misc.currency_code') == 'AZN') {

    //     $setting = Settings::first();

    //     $azn_rate = $setting?->azn_rate;
    //     $converted_rate = floatval($price) * floatval($azn_rate);

    //     return setSymbol(numberFormat($converted_rate));
    // } elseif (config('misc.currency_code') == 'SAR') {
    //     $setting = Settings::first();

    //     $sar_rate = $setting?->sar_rate;
    //     $converted_rate = floatval($price) * floatval($sar_rate);

    //     return setSymbol(numberFormat($converted_rate));
    // } elseif (config('misc.currency_code') == 'GBP') {
    //     $setting = Settings::first();
    //     $pound_rate = $setting?->pound_rate;
    //     $converted_rate = floatval($price) * floatval($pound_rate);
    //     return setSymbol(numberFormat($converted_rate));
    // } else {

    //     return setSymbol(numberFormat($price));
    // }
}

function setSymbol($price = 0)
{
    if (config('misc.currency_position') == 'right') {

        return $price . ' ' . config('misc.currency_symbol');
    } else {

        return config('misc.currency_symbol') . $price;
    }
}

if (!function_exists('checkMailConfig')) {
    function checkMailConfig()
    {
        $status = config('mail.mailers.smtp.transport') && config('mail.mailers.smtp.host') && config('mail.mailers.smtp.port') && config('mail.mailers.smtp.username') && config('mail.mailers.smtp.password') && config('mail.mailers.smtp.encryption') && config('mail.from.address') && config('mail.from.name');

        return $status ? 1 : 0;
    }
}

if (!function_exists('numberFormat')) {
    function numberFormat(string $price = null, string $decimals = "2"): string
    {
        $floatNumber = floatval($price);
        $formatted = sprintf("%.{$decimals}f", $floatNumber);
        return $formatted;
        // $floatNumber = floatval($price);
        // $formatted = number_format($floatNumber, intval($decimals));
        // return $formatted;
    }
}


function deleteImage($image)
{
    if (file_exists($image)) {
        @unlink($image);
    }
}

function uploadImage($file, $path)
{
    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $filePath = $path . '/' . $fileName;

    Storage::disk(config('filesystems.default'))->put($filePath, file_get_contents($file));

    return Storage::disk(config('filesystems.default'))->url($filePath);
}

function getPlanProductCount($price)
{
    $plan = Plan::where('stripe_id', $price)->first();
    if ($plan) {
        return $plan->product_count;
    } else {
        return 0;
    }
}

function getPlan($price)
{
    $plan = Plan::where('stripe_id', $price)->first();
    if ($plan) {
        return $plan;
    } else {
        return false;
    }
}

function getCurrentDomain(): string
{
    $domain = request()->getHost();

    //  If it is localhost then default domain will be scentq.com
    if (in_array(request()->getHost(), ["127.0.0.1", 'localhost'])) {
        $domain = 'scentq.com';
    }

    return $domain ?? 'scentq.com';
}

function cardInfo($user_id)
{

    $user = User::where('id', $user_id)->first();

    if ($user) {

        try {
            $paymentMethod = $user->paymentMethods();

            // Check if there are payment methods and get the first one
            $card_info = isset($paymentMethod[0]) ? $paymentMethod[0]?->card : null;

            return $card_info;
        } catch (\Throwable $th) {
            return null;
        }
    }

    return null;
}

function getStripeProduct()
{
    if (request()->getHost() == "scentq.co.uk") {
        $prouduct = Meta::getSetting('cashier_stripe_fragrance_subscription_for_uk');
    } else {
        $prouduct = Meta::getSetting('cashier_stripe_fragrance_subscription');
    }

    return $prouduct;
}

function fiftyPercentOff()
{
    $current_plan = PlanService::getCurrentDefaultPlan();
    $setting = Settings::first();

    if ($current_plan && $setting?->first_month_subscribe_discount_status) {

        $totalAmount = $current_plan?->total_price;
        $discountAmount = $setting?->first_month_subscribe_discount_percentage;
        // Calculate the discount amount
        // $discountAmount = $totalAmount * ($discountPercentage / 100);
        // Calculate the final amount after the discount
        $finalAmount = $totalAmount - $discountAmount;
        return $finalAmount;
    } else {
        return $current_plan?->total_price ?? 0;
    }
}


if (!function_exists('translations')) {
    function translations($json)
    {
        if (!file_exists($json)) {
            return [];
        }

        return json_decode(file_get_contents($json), true);
    }
}
