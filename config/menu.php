<?php

use App\Models\Brand;
use App\Models\Page;
use App\Models\Product;

    return[
        'menu' => [
            'locations' => [
                'main' => 'Main Menu',
                'header' => 'Header Top',
                'footer' => 'Footer Menu'
            ],
        ],
        'menuables' => [Page::class, Brand::class, Product::class]
    ];
