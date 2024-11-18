<?php
return [
    [
        'title' => 'Landing',
        'slug' => 'women',
        'is_builtin' => true,
        'type' => 'landing',
        'template' => 'Landing',
        'sections' => [
            [
                'component' => 'Offer',
                'props' => [
                    'text' => 'We Support Ukraine. We Stand for Peace. Click here for details'
                ]
            ],
            [
                'component' => 'Slider',
                'props' => [
                    'title' => 'Be Fresh Everyday',
                    'sub_title' => 'Get more you with unique member experiences, products, giveaways, and more.',
                    'counter_box' => [
                        'text' => 'Buy Your First Product and Get 50% Discount',
                        'minute' => '2',
                        'second' => '41',
                    ],
                    'slides' => [
                        [
                            'image'=> 'https://via.placeholder.com/952x767',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/952x767',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/952x767',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/952x767',
                        ]
                    ]
                ]
            ],
            [
                'component' => 'ProductSlider',
                'props' => [
                    'title' => 'Be Fresh Everyday',
                    'sub_title' => 'Get more you with unique member experiences, products, giveaways, and more.',
                    'counter_box' => [
                        'text' => 'Buy Your First Product and Get 50% Discount',
                        'minute' => '2',
                        'second' => '41',
                    ],
                ]
            ],
            [
                'component' => 'Process',
                'props' => [
                    'title' => 'Here’s how to get it:',
                    'steps' => [
                        [
                            'title' => 'Pick Your Favorite scent',
                            'desc' => 'Choose what you\'d like to try from our best sellers — you\'ll get access to our full catalog after subscribing.',
                            'image' => 'https://via.placeholder.com/478x424'
                        ],
                        [
                            'title' => 'Activate Your Subscription',
                            'desc' => 'Dressed in a sleek, refillable case, our 8 mL bottles hold roughly 140 sprays each, and should last until your next order.',
                            'image' => 'https://via.placeholder.com/478x424'
                        ],
                        [
                            'title' => 'Receive Your Fragrance',
                            'desc' => 'We\'ll throw in a free fragrance case with your first order. Cancel anytime without consequences.',
                            'image' => 'https://via.placeholder.com/478x424'
                        ],
                    ],
                    'button_text' => 'Get Started with quiz',
                    'button_link' => env('APP_URL') . '/smart-recommendations'
                ]
            ],
            [
                'component' => 'Partners',
                'props' => [
                    'title' => 'Top Curated Fragrances',
                    'sub_title' => 'Best fragrances on the market selected by our team of experts.',
                    'partners' => [
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                    ],
                    'button_text' => 'Get Started with A quiz',
                    'button_link' => env('APP_URL') . '/smart-recommendations'
                ]
            ],
            [
                'component' => 'CallToAction',
                'props' => [
                    'title' => 'Feeling Mysterious? Relaxed? Flirty?',
                    'sub_title' => 'Take our quiz and we’ll match your persona to fragrances tailored just for you.',
                    'button_text' => 'Get Started with A quiz',
                    'button_link' => env('APP_URL') . '/smart-recommendations',
                    'slides' => [
                        [
                            'image' => 'https://via.placeholder.com/1035x550',
                        ],
                        [
                            'image' => 'https://via.placeholder.com/1035x550',
                        ],
                        [
                            'image' => 'https://via.placeholder.com/1035x550',
                        ],
                        [
                            'image' => 'https://via.placeholder.com/1035x550',
                        ],
                        [
                            'image' => 'https://via.placeholder.com/1035x550',
                        ]
                    ]
                ]
            ],
            [
                'component' => 'BestSellingProducts',
                'props' => [
                    'title' => 'Select what you\'d like to try from our best-sellers',
                    'load_more' => 'View More Perfume'
                ]
            ],
            [
                'component' => 'ParallaxCallToAction',
                'props' => [
                    'title' => 'Get Access To Over 1600 Products Every Single Month!',
                    'button_text' => 'Create your account',
                    'button_link' => env('APP_URL') . '/register'
                ]
            ]
        ]
    ],
    [
        'title' => 'Men',
        'slug' => 'men',
        'is_builtin' => true,
        'type' => 'landing',
        'template' => 'Landing',
        'sections' => [
            [
                'component' => 'Offer',
                'props' => [
                    'text' => 'We Support Ukraine. We Stand for Peace. Click here for details'
                ]
            ],
            [
                'component' => 'Slider',
                'props' => [
                    'title' => 'Be Fresh Everyday',
                    'sub_title' => 'Get more you with unique member experiences, products, giveaways, and more.',
                    'counter_box' => [
                        'text' => 'Buy Your First Product and Get 50% Discount',
                        'minute' => '2',
                        'second' => '41',
                    ],
                    'slides' => [
                        [
                            'image'=> 'https://via.placeholder.com/974x737',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/974x737',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/974x737',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/974x737',
                        ]
                    ]
                ]
            ],
            [
                'component' => 'Process',
                'props' => [
                    'title' => 'Here’s how to get it:',
                    'steps' => [
                        [
                            'title' => '01. Pick Your Favorite scent',
                            'desc' => 'Choose what you\'d like to try from our best sellers — you\'ll get access to our full catalog after subscribing.',
                            'image' => 'https://via.placeholder.com/428'
                        ],
                        [
                            'title' => '0.2 Activate Your Subscription',
                            'desc' => 'Dressed in a sleek, refillable case, our 8 mL bottles hold roughly 140 sprays each, and should last until your next order.',
                            'image' => 'https://via.placeholder.com/428'
                        ],
                        [
                            'title' => '0.3 Receive Your Fragrance',
                            'desc' => 'We\'ll throw in a free fragrance case with your first order. Cancel anytime without consequences.',
                            'image' => 'https://via.placeholder.com/428'
                        ],
                    ],
                    'button_text' => 'Get Started with quiz',
                    'button_link' => env('APP_URL') . '/smart-recommendations'
                ]
            ],
            [
                'component' => 'Partners',
                'props' => [
                    'title' => 'Top Curated Fragrances',
                    'sub_title' => 'Best fragrances on the market selected by our team of experts.',
                    'image' => 'https://via.placeholder.com/885x814',
                    'partners' => [
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                    ],
                    'button_text' => 'Get Started with A quiz',
                    'button_link' => env('APP_URL') . '/smart-recommendations'
                ]
            ],
            [
                'component' => 'CallToAction',
                'props' => [
                    'title' => 'Feeling Mysterious? Relaxed? Flirty?',
                    'sub_title' => 'Take our quiz and we’ll match your persona to fragrances tailored just for you.',
                    'button_text' => 'Get Started with A quiz',
                    'button_link' => env('APP_URL') . '/smart-recommendations',
                    'slides' => [
                        [
                            'image' => 'https://via.placeholder.com/1035x550',
                        ],
                        [
                            'image' => 'https://via.placeholder.com/1035x550',
                        ],
                        [
                            'image' => 'https://via.placeholder.com/1035x550',
                        ],
                        [
                            'image' => 'https://via.placeholder.com/1035x550',
                        ],
                        [
                            'image' => 'https://via.placeholder.com/1035x550',
                        ]
                    ]
                ]
            ],
            [
                'component' => 'BestSellingProducts',
                'props' => [
                    'title' => 'Select what you\'d like to try from our best-sellers',
                    'load_more' => 'View More Perfume'
                ]
            ],
            [
                'component' => 'ParallaxCallToAction',
                'props' => [
                    'title' => 'Get Access To Over 1600 Products Every Single Month!',
                    'button_text' => 'Create your account',
                    'button_link' => env('APP_URL') . '/register'
                ]
            ],
            [
                'component' => 'Newsletter',
                'props' => [
                    'title' => 'SubscribeOur Newsletter'
                ]
            ]
        ]
    ],
    [
        'title' => 'Smart Recommendations',
        'slug' => 'smart-recommendations',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Quiz',
        'sections' => []
    ],
    [
        'title' => 'Register',
        'slug' => 'register',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Auth/Registration'
    ],
    [
        'title' => 'Login',
        'slug' => 'login',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Auth/Login'
    ],
    [
        'title' => 'Reset Password',
        'slug' => 'reset-password',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Auth/Email'
    ],
    [
        'title' => 'Women Home',
        'slug' => 'women-home',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Home',
        'sections' => [
            [
                'component' => 'Slider',
                'props' => [
                    'title' => 'Be Fresh Everyday',
                    'sub_title' => 'Get more you with unique member experiences, products, giveaways, and more.',
                    'counter_box' => [
                        'text' => 'Buy Your First Product and Get 50% Discount',
                        'minute' => '2',
                        'second' => '41',
                    ],
                    'slides' => [
                        [
                            'image'=> 'https://via.placeholder.com/508x737',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/508x737',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/508x737',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/508x737',
                        ],
                    ]
                ]
            ],
            [
                'component' => 'Feature',
                'props' => [
                    'feature_iterator' => [
                        [
                            'image' => 'https://via.placeholder.com/50',
                            'title' => 'Authentic Brands',
                            'sub_title' => 'Popular brand in the world'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/50',
                            'title' => 'Sized For Travel',
                            'sub_title' => 'Flexible to carry anywhere'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/50',
                            'title' => 'Cancel Anytime',
                            'sub_title' => 'Free cancellation'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/50',
                            'title' => 'No Hidden Fees',
                            'sub_title' => 'Shop with happiness'
                        ],
                    ]
                ]
            ],
            [
                'component' => 'Shipment',
                'props' => [
                    'title' => 'Upcoming shipments',
                ]
            ],
            [
                'component' => 'Recommendation',
                'props' => [
                    'title' => 'Recommendations Based On Your Quiz',
                    'button_text' => 'View All',
                    'button_link' => env('APP_URL') . '/recommendation'
                ]
            ],
            [
                'component' => 'CapsuleCollection',
                'props' => [
                    'title' => 'ScentQ Capsule Collection',
                    'sub_title' => 'Whether you\'re on that WFH grind or are dreaming of warmer climes, our curated fragrance collections are here to kick off 2021 on a scent-sational note.',
                ]
            ],
            [
                'component' => 'NewFragrances',
                'props' => [
                    'title' => 'New Fine Fragrances',
                ]
            ],
            [
                'component' => 'Partners',
                'props' => [
                    'title' => 'Top Curated Fragrances',
                    'sub_title' => 'Best fragrances on the market selected by our team of experts.',
                    'image' => 'https://via.placeholder.com/885x814',
                    'button_text' => 'Get Started with A quiz',
                    'button_link' => env('APP_URL') . '/smart-recommendations',
                    'partners' => [
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ]
                    ]
                ]
            ],
            [
                'component' => 'TopRatedProducts',
                'props' => [
                    'title' => 'Top Rated Products',
                ]
            ],
            [
                'component' => 'TrendingNotes',
                'props' => [
                    'title' => 'Trending Notes',
                    'sub_title' => 'Discover scents based on notes featured in the top-rated fragrances of the last three months. Click each image to filter by note.',
                ]
            ],
            [
                'component' => 'SubscriptionExtra',
                'props' => [
                    'title' => 'MAKE THE MOST OF YOUR SUBSCRIPTION',
                    'sub_title' => 'Because we want you to get everything you can out of your membership, we’ve collected all the special features, offers and promotions on one page. Happy shopping!',
                    'cards' => [
                        [
                            'image' => 'https://via.placeholder.com/470x331',
                            'title' => 'Tell all your friends',
                            'desc' => 'Recommend your friends to ScentQ, and you’ll both get a free month on your subscription. You get a bottle, they get a bottle, everyone wins.',
                            'button_text' => 'Share With Your Friends',
                            'button_link' => env('APP_URL') . '/invite-friends'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/470x331',
                            'title' => 'Tell all your friends',
                            'desc' => 'Recommend your friends to ScentQ, and you’ll both get a free month on your subscription. You get a bottle, they get a bottle, everyone wins.',
                            'button_text' => 'Share With Your Friends',
                            'button_link' => env('APP_URL') . '/invite-friends'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/470x331',
                            'title' => 'Tell all your friends',
                            'desc' => 'Recommend your friends to ScentQ, and you’ll both get a free month on your subscription. You get a bottle, they get a bottle, everyone wins.',
                            'button_text' => 'Share With Your Friends',
                            'button_link' => env('APP_URL') . '/invite-friends'
                        ],
                    ]
                ]
            ]
        ]
    ],
    [
        'title' => 'Men Home',
        'slug' => 'men-home',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Home',
        'sections' => [
            [
                'component' => 'Slider',
                'props' => [
                    'title' => 'Be Fresh Everyday',
                    'sub_title' => 'Get more you with unique member experiences, products, giveaways, and more.',
                    'counter_box' => [
                        'text' => 'Buy Your First Product and Get 50% Discount',
                        'minute' => '2',
                        'second' => '41',
                    ],
                    'slides' => [
                        [
                            'image'=> 'https://via.placeholder.com/508x737',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/508x737',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/508x737',
                        ],
                        [
                            'image'=> 'https://via.placeholder.com/508x737',
                        ],
                    ]
                ]
            ],
            [
                'component' => 'Feature',
                'props' => [
                    'feature_iterator' => [
                        [
                            'image' => 'https://via.placeholder.com/50',
                            'title' => 'Authentic Brands',
                            'sub_title' => 'Popular brand in the world'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/50',
                            'title' => 'Sized For Travel',
                            'sub_title' => 'Flexible to carry anywhere'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/50',
                            'title' => 'Cancel Anytime',
                            'sub_title' => 'Free cancellation'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/50',
                            'title' => 'No Hidden Fees',
                            'sub_title' => 'Shop with happiness'
                        ],
                    ]
                ]
            ],
            [
                'component' => 'Shipment',
                'props' => [
                    'title' => 'Upcoming shipments',
                ]
            ],
            [
                'component' => 'Recommendation',
                'props' => [
                    'title' => 'Recommendations Based On Your Quiz',
                    'button_text' => 'View All',
                    'button_link' => env('APP_URL') . '/recommendation'
                ]
            ],
            [
                'component' => 'CapsuleCollection',
                'props' => [
                    'title' => 'ScentQ Capsule Collection',
                    'sub_title' => 'Whether you\'re on that WFH grind or are dreaming of warmer climes, our curated fragrance collections are here to kick off 2021 on a scent-sational note.',
                ]
            ],
            [
                'component' => 'NewFragrances',
                'props' => [
                    'title' => 'New Fine Fragrances',
                ]
            ],
            [
                'component' => 'Partners',
                'props' => [
                    'title' => 'Top Curated Fragrances',
                    'sub_title' => 'Best fragrances on the market selected by our team of experts.',
                    'image' => 'https://via.placeholder.com/885x814',
                    'button_text' => 'Get Started with A quiz',
                    'button_link' => env('APP_URL') . '/smart-recommendations',
                    'partners' => [
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ],
                        [
                            'image' =>'https://via.placeholder.com/173x27',
                            'link' => '#'
                        ]
                    ]
                ]
            ],
            [
                'component' => 'TopRatedProducts',
                'props' => [
                    'title' => 'Top Rated Products',
                ]
            ],
            [
                'component' => 'TrendingNotes',
                'props' => [
                    'title' => 'Trending Notes',
                    'sub_title' => 'Discover scents based on notes featured in the top-rated fragrances of the last three months. Click each image to filter by note.',
                ]
            ],
            [
                'component' => 'SubscriptionExtra',
                'props' => [
                    'title' => 'MAKE THE MOST OF YOUR SUBSCRIPTION',
                    'sub_title' => 'Because we want you to get everything you can out of your membership, we’ve collected all the special features, offers and promotions on one page. Happy shopping!',
                    'cards' => [
                        [
                            'image' => 'https://via.placeholder.com/470x331',
                            'title' => 'Tell all your friends',
                            'desc' => 'Recommend your friends to ScentQ, and you’ll both get a free month on your subscription. You get a bottle, they get a bottle, everyone wins.',
                            'button_text' => 'Share With Your Friends',
                            'button_link' => env('APP_URL') . '/invite-friends'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/470x331',
                            'title' => 'Tell all your friends',
                            'desc' => 'Recommend your friends to ScentQ, and you’ll both get a free month on your subscription. You get a bottle, they get a bottle, everyone wins.',
                            'button_text' => 'Share With Your Friends',
                            'button_link' => env('APP_URL') . '/invite-friends'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/470x331',
                            'title' => 'Tell all your friends',
                            'desc' => 'Recommend your friends to ScentQ, and you’ll both get a free month on your subscription. You get a bottle, they get a bottle, everyone wins.',
                            'button_text' => 'Share With Your Friends',
                            'button_link' => env('APP_URL') . '/invite-friends'
                        ],
                    ]
                ]
            ]
        ]
    ],
    [
        'title' => 'Product',
        'slug' => 'product',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Product',
    ],
    [
        'title' => 'Filter',
        'slug' => 'filter',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Filter',
        'sections' => []
    ],
    [
        'title' => 'All Brand',
        'slug' => 'all-brand',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'AllBrands',
        'sections' => [
            [
                'component' => 'Explorebrands',
                'props' => [
                    'title' => 'Explore popular brands',
                    'popularBrands' => [
                        [
                            'image' => 'https://via.placeholder.com/368x255',
                            'link' => '#'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/368x255',
                            'link' => '#'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/368x255',
                            'link' => '#'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/368x255',
                            'link' => '#'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/368x255',
                            'link' => '#'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/368x255',
                            'link' => '#'
                        ]
                    ]
                ]
            ],
            [
                'component' => 'Discoverbrands',
                'props' => [
                    'title' => 'Discover new brands',
                    'brandCards' => [
                        [
                            'title' => 'Atelier Cologne',
                            'desc' => 'Merged from citrus and herbal notes in a stronger concentration for a richer and longer lasting fragrant effect',
                            'image' => 'https://via.placeholder.com/368x255',
                            'button_text' => '0 products',
                            'button_link' => '#',
                        ],
                        [
                            'title' => 'Atelier Cologne',
                            'desc' => 'Merged from citrus and herbal notes in a stronger concentration for a richer and longer lasting fragrant effect',
                            'image' => 'https://via.placeholder.com/368x255',
                            'button_text' => '0 products',
                            'button_link' => '#',
                        ],
                        [
                            'title' => 'Atelier Cologne',
                            'desc' => 'Merged from citrus and herbal notes in a stronger concentration for a richer and longer lasting fragrant effect',
                            'image' => 'https://via.placeholder.com/368x255',
                            'button_text' => '0 products',
                            'button_link' => '#',
                        ]
                    ]
                ]
            ],
            [
                'component' => 'Cleanbrands',
                'props' => [
                    'title' => 'Clean brands',
                    'CleanCards' => [
                        [
                            'title' => 'Sanctuary',
                            'desc' => 'The brand creates cleanconscious, socially resposible fragrances',
                            'image' => 'https://via.placeholder.com/187x33',
                            'button_text' => 'View 3 products',
                            'button_link' => '#',
                        ],
                        [
                            'title' => 'Sanctuary',
                            'desc' => 'The brand creates cleanconscious, socially resposible fragrances',
                            'image' => 'https://via.placeholder.com/187x33',
                            'button_text' => 'View 3 products',
                            'button_link' => '#',
                        ],
                        [
                            'title' => 'Sanctuary',
                            'desc' => 'The brand creates cleanconscious, socially resposible fragrances',
                            'image' => 'https://via.placeholder.com/187x33',
                            'button_text' => 'View 3 products',
                            'button_link' => '#',
                        ]
                    ]
                ]
            ]
        ]
    ],
    [
        'title' => 'Collection For Men',
        'slug' => 'collection-for-men',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Collections',
        'sections' => [
            [
                'component' => 'Collection',
                'props' => [
                    'title' => 'ScentQ Capsule Collection',
                    'sub_title' => 'Whether you are on that WFH grind or are dreaming of warmer climes, our curated fragrance collections are here to kick off 2021 on a scent-sational note',
                    'type' => 'capsule'
                ]
            ], [
                'component' => 'Collection',
                'props' => [
                    'title' => 'ScentQ Curated Collection',
                    'sub_title' => 'Discover our curated selection of must-have scents.',
                    'type' => 'curated'
                ]
            ]
        ]
    ],
    [
        'title' => 'Collection For Women',
        'slug' => 'collection-for-women',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Collections',
        'sections' => [
            [
                'component' => 'Collection',
                'props' => [
                    'title' => 'ScentQ Capsule Collection',
                    'sub_title' => 'Whether you are on that WFH grind or are dreaming of warmer climes, our curated fragrance collections are here to kick off 2021 on a scent-sational note',
                    'type' => 'capsule'
                ]
            ], [
                'component' => 'Collection',
                'props' => [
                    'title' => 'ScentQ Curated Collection',
                    'sub_title' => 'Discover our curated selection of must-have scents.',
                    'type' => 'curated'
                ]
            ]
        ]
    ],
    [
        'title' => 'Terms And Conditions',
        'slug' => 'terms-and-conditions',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Page',
        'sections' => []
    ],
    [
        'title' => 'Privacy Policy',
        'slug' => 'privacy-policy',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Page',
        'sections' => []
    ],
    [
        'title' => 'Invite Friends',
        'slug' => 'invite',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'Invite',
        'sections' => [
            [
                'component' => 'Heading',
                'props' => [
                    'title' => 'Get your free perfumes by Inviting your friends.',
                ]
            ], [
                'component' => 'HowItWorks',
                'props' => [
                    'title' => 'Here how it works:',
                    'options' => [
                        [
                            'title' => 'Are you in?',
                            'desc' => 'Only active ScentQ subscribers can participate'
                        ],
                        [
                            'title' => 'Invite Your Friends',
                            'desc' => 'For each friend that subscribed, you\'ll be rewarded with a free fragrance on your subscription.'
                        ],
                        [
                            'title' => 'Everyone Wins!',
                            'desc' => 'Your friend also receives a free scent'
                        ],
                        [
                            'title' => 'Both Of You Get Free Perfume!',
                            'desc' => ''
                        ],
                    ]
                ]
            ], [
                'component' => 'Counter',
                'props' => [
                    'title' => 'Our subscribers have been getting major benefits from the program',
                    'counters' => [
                        [
                            'number' => '72500',
                            'desc' => 'free fragrances earned'
                        ],
                        [
                            'number' => '72500',
                            'desc' => 'shares'
                        ]
                    ]
                ]
            ], [
                'component' => 'GiftStatistics',
                'props' => [
                    'mini_title' => 'YOUR GIFT STATISTICS',
                    'sub_title' => 'When at least one of the invited friends joins ScentQ, you will receive free products',
                ]
            ], [
                'component' => 'BeforeFooter',
                'props' => [
                    'title' => 'What are you waiting for? Tell your friends, smell great',
                    'image' => 'https://via.placeholder.com/432X432'
                ]
            ]
        ]
    ],
    [
        'title' => 'Case Subscription',
        'slug' => 'case-subscription',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'CaseSubscription',
        'sections' => [
            [
                'component' => 'CaseSubscriptionPage',
                'props' => [
                    'title' => 'Just In Case',
                    'sub_title' => 'Upgrade to include an atomizer case in every order for an extra $10.00 per month.',
                    'button_text' => 'Get a case monthly',
                    'image' => 'https://via.placeholder.com/1506X436'
                ]
            ]
        ]
    ],
    [
        'title' => 'About Us',
        'slug' => 'about-us',
        'is_builtin' => true,
        'type' => 'page',
        'template' => 'AboutUs',
        'sections' => [
            [
                'component' => 'Heading',
                'props' => [
                    'heading_desc' => 'What is ScentQ? ScentQ is about the fun and magic of fragrance. We designed ScentQ for the pickiest girl- or boy- to let you date luxury perfumes before marrying them. How we started Born out of frustration with the “perfume graveyard” — expensive bottles of designer perfume collecting dust on your dresser or cabinet — ScentQ was created to provide an alternative that is both practical and exciting.',
                ]
            ],
            [
                'component' => 'Quote',
                'props' => [
                    'quote' => '“Welcome to ScentQ, friends! We hope that you feel at home here. It has always been our dream to make this site a friendly space where you can explore fragrances, experiment with them and mix up your routine without having to spend hundreds of dollars or commit to one single bottle for years. Play, have fun, keep things fresh — you are designed to.”',
                    'quote_by' => 'With ❤️ Mariya Nurislamova',
                    'designation' => 'Founder & CEO'
                ]
            ],
            [
                'component' => 'MeetTheFounders',
                'props' => [
                    'title' => 'Meet the founders',
                    'founders' => [
                        [
                            'image' => 'https://via.placeholder.com/64',
                            'name' => 'Mariya Nurislamova',
                            'designation' => 'Founder & CEO',
                            'social_text' => 'Linkedin',
                            'social_link' => '#'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/64',
                            'name' => 'Mariya Nurislamova',
                            'designation' => 'Founder & CEO',
                            'social_text' => 'Linkedin',
                            'social_link' => '#'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/64',
                            'name' => 'Mariya Nurislamova',
                            'designation' => 'Founder & CEO',
                            'social_text' => 'Linkedin',
                            'social_link' => '#'
                        ],
                        [
                            'image' => 'https://via.placeholder.com/64',
                            'name' => 'Mariya Nurislamova',
                            'designation' => 'Founder & CEO',
                            'social_text' => 'Linkedin',
                            'social_link' => '#'
                        ],
                    ]
                ]
            ],
            [
                'component' => 'Contact',
                'props' => [
                    'address' => '1600 Perrineville Road, Ste. 2 – 395, Monroe Twp., NJ 08831',
                    'email' => 'info@scentbird.com',
                    'support_button_text' => 'Please click here',
                    'button_Link' => '#'
                ]
            ]
        ]
    ]
];
