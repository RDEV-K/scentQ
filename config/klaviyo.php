<?php

return [

    /*
     * Enable or disable Klaviyo script rendering and server-side jobs.
     * Useful for local development.
     */
    'enabled' => (bool) env('KLAVIYO_ENABLED', true),
    'private_api_key' => env('KLAVIYO_PRIVATE_API_KEY', ''),
    'public_api_key' => env('KLAVIYO_PUBLIC_API_KEY', ''),

];
