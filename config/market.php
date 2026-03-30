<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Market Data Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default market data API provider that will be
    | used by the application for fetching agricultural commodity prices.
    |
    */

    'default' => env('MARKET_PROVIDER', 'custom'),

    /*
    |--------------------------------------------------------------------------
    | Market Data Providers
    |--------------------------------------------------------------------------
    |
    | Configure your market data API providers here.
    |
    */

    'providers' => [

        'custom' => [
            'api_key' => env('MARKET_API_KEY'),
            'base_url' => env('MARKET_API_URL'),
        ],

        // Add additional providers as needed
        // 'usda' => [
        //     'api_key' => env('USDA_API_KEY'),
        //     'base_url' => 'https://api.nal.usda.gov/fdc/v1',
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Market data caching configuration.
    |
    */

    'cache' => [
        'enabled' => env('MARKET_CACHE_ENABLED', true),
        'prices_ttl' => env('MARKET_PRICES_TTL', 3600), // 1 hour
        'historical_ttl' => env('MARKET_HISTORICAL_TTL', 86400), // 24 hours
    ],

    /*
    |--------------------------------------------------------------------------
    | Supported Commodities
    |--------------------------------------------------------------------------
    |
    | List of agricultural commodities tracked by the system.
    |
    */

    'commodities' => [
        'grains' => [
            'wheat',
            'corn',
            'rice',
            'barley',
            'sorghum',
            'oats',
            'millet',
        ],
        'vegetables' => [
            'tomatoes',
            'onions',
            'potatoes',
            'carrots',
            'cabbage',
            'peppers',
            'lettuce',
        ],
        'fruits' => [
            'apples',
            'oranges',
            'bananas',
            'grapes',
            'mangoes',
            'avocados',
        ],
        'legumes' => [
            'soybeans',
            'chickpeas',
            'lentils',
            'beans',
            'peas',
        ],
        'cash_crops' => [
            'cotton',
            'coffee',
            'cocoa',
            'sugarcane',
            'tobacco',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Price Alert Settings
    |--------------------------------------------------------------------------
    |
    | Configure price alert thresholds and notification settings.
    |
    */

    'alerts' => [
        'price_change_threshold' => env('MARKET_PRICE_ALERT_THRESHOLD', 5), // percentage
        'check_interval' => env('MARKET_CHECK_INTERVAL', 3600), // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | Default currency and supported currencies for price display.
    |
    */

    'currency' => [
        'default' => env('MARKET_DEFAULT_CURRENCY', 'USD'),
        'supported' => ['USD', 'EUR', 'GBP', 'KES', 'NGN', 'ZAR', 'INR'],
    ],

];
