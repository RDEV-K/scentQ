<?php

namespace App\Services;

use App\Models\SocialLink;
use Illuminate\Support\Facades\Cache;

class SocialLinkService
{
    const CACHE_KEY = 'social_links';

    /**
     * Get all social links
     * @return SocialLink[]
     */
    public static function getAllLinks()
    {
        return Cache::rememberForever(
            static::CACHE_KEY,
            fn () => SocialLink::query()
                ->select(['id', 'name', 'link', 'icon', 'order', 'full_url'])
                ->orderBy('order', 'ASC')
                ->get()
        );
    }

    public static function forgetCache(): void
    {
        Cache::forget(static::CACHE_KEY);
    }
}
