<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

trait KlaviyoTrait
{
    public function initKlaviyo($event_name, $user, $data): void
    {
        if (config('klaviyo.enabled')) {

            $url = 'https://a.klaviyo.com/api/events/';

            $payload = [
                'data' => [
                    'type' => 'event',
                    'attributes' => [
                        'profile' => $user,
                        'metric' => [
                            'name' => $event_name
                        ],
                        'properties' => $data,
                        'time' => now(),
                        'unique_id' => 'SQ6' . Str::random(32),
                    ],
                ],
            ];

            $headers = [
                'Accept' => 'application/json',
                'Revision' => '2023-01-24',
                'Content-Type' => 'application/json',
                'Authorization' => 'Klaviyo-API-Key ' . config('klaviyo.private_api_key'),
            ];

            Http::withHeaders($headers)->post($url, $payload);
        }
    }

    public function searchHistory(string $keyword): void
    {
        $user = '';
        if (auth()->check()) {
            $user = auth()->user();
        } else {
            $user = [
                'email' => 'un-authenticate@mail.com',
                'first_name' => 'un-authenticate',
                'last_name' => 'user',
            ];
        }

        $event_name = 'Search History';
        $klaviyo_user = [
            '$email' => $user['email'],
            '$first_name' => $user['first_name'],
            '$last_name' => $user['last_name']
        ];
        $data = [
            'Keyword' => $keyword,
        ];

        $this->initKlaviyo($event_name, $klaviyo_user, $data);
    }

    public function orderPlaced(object $order, object $user): void
    {
        $event_name = 'Placed Order';
        $klaviyo_user = [
            '$email' => $user['email'],
            '$first_name' => $user['first_name'],
            '$last_name' => $user['last_name']
        ];
        $data = [
            'OrderId' => $order?->order_no,
            'GrossTotal' => $order?->gross_total,
            'NetTotal' => $order?->net_total,
            'Currency' => config('misc.currency_code'),
            'Value' => intval($order?->gross_total),
        ];

        $this->initKlaviyo($event_name, $klaviyo_user, $data);
    }

    public function addToQueue(object $product, object $user): void
    {
        $event_name = 'Add To Queue';
        $klaviyo_user = [
            '$email' => $user['email'],
            '$first_name' => $user['first_name'],
            '$last_name' => $user['last_name']
        ];
        $data = [
            'ProductTitle' => $product?->title,
            'ProductId' => $product?->id,
        ];

        $this->initKlaviyo($event_name, $klaviyo_user, $data);
    }

    public function addToCart(object $product, object $user): void
    {
        $event_name = 'Add To Cart';
        $klaviyo_user = [
            '$email' => $user['email'],
            '$first_name' => $user['first_name'],
            '$last_name' => $user['last_name']
        ];
        $data = [
            'ProductTitle' => $product?->title,
            'ProductId' => $product?->id,
        ];

        $this->initKlaviyo($event_name, $klaviyo_user, $data);
    }

    public function startedCheckout(string $cart_item, object $user): void
    {
        $event_name = 'Started Checkout';
        $klaviyo_user = [
            '$email' => $user['email'],
            '$first_name' => $user['first_name'],
            '$last_name' => $user['last_name']
        ];
        $data = [
            'CartItem' => $cart_item,
        ];

        $this->initKlaviyo($event_name, $klaviyo_user, $data);
    }

    public function browseProduct(string $url): void
    {
        $user = '';
        if (auth()->check()) {
            $user = auth()->user();
        } else {
            $user = [
                'email' => 'un-authenticate@mail.com',
                'first_name' => 'un-authenticate',
                'last_name' => 'user',
            ];
        }

        $event_name = 'Browse Product';
        $klaviyo_user = [
            '$email' => $user['email'],
            '$first_name' => $user['first_name'],
            '$last_name' => $user['last_name']
        ];
        $data = [
            'URL' => $url,
        ];

        $this->initKlaviyo($event_name, $klaviyo_user, $data);
    }
}
