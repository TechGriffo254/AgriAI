<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Weather Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default weather API provider that will be used
    | by the application for fetching weather data.
    |
    */

    'default' => env('WEATHER_PROVIDER', 'openweathermap'),

    /*
    |--------------------------------------------------------------------------
    | Weather API Providers
    |--------------------------------------------------------------------------
    |
    | Configure your weather API providers here. You can use multiple providers
    | for redundancy or different data needs.
    |
    */

    'providers' => [

        'openweathermap' => [
            'api_key' => env('OPENWEATHERMAP_API_KEY'),
            'base_url' => 'https://api.openweathermap.org/data/2.5',
            'units' => env('WEATHER_UNITS', 'metric'), // metric, imperial, or standard
        ],

        'weatherapi' => [
            'api_key' => env('WEATHERAPI_KEY'),
            'base_url' => 'https://api.weatherapi.com/v1',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Weather data caching configuration. Reduces API calls and improves
    | response times.
    |
    */

    'cache' => [
        'enabled' => env('WEATHER_CACHE_ENABLED', true),
        'current_ttl' => env('WEATHER_CURRENT_TTL', 1800), // 30 minutes
        'forecast_ttl' => env('WEATHER_FORECAST_TTL', 3600), // 1 hour
        'historical_ttl' => env('WEATHER_HISTORICAL_TTL', 86400), // 24 hours
    ],

    /*
    |--------------------------------------------------------------------------
    | Alert Thresholds
    |--------------------------------------------------------------------------
    |
    | Configure thresholds for weather alerts that affect farming activities.
    |
    */

    'alerts' => [
        'frost_warning_temp' => env('FROST_WARNING_TEMP', 2), // Celsius
        'heat_warning_temp' => env('HEAT_WARNING_TEMP', 35), // Celsius
        'heavy_rain_threshold' => env('HEAVY_RAIN_THRESHOLD', 50), // mm per day
        'drought_days' => env('DROUGHT_ALERT_DAYS', 7), // Days without significant rain
        'wind_warning_speed' => env('WIND_WARNING_SPEED', 50), // km/h
    ],

    /*
    |--------------------------------------------------------------------------
    | Forecast Settings
    |--------------------------------------------------------------------------
    |
    | Configure how far ahead to fetch and analyze weather forecasts.
    |
    */

    'forecast' => [
        'days_ahead' => env('WEATHER_FORECAST_DAYS', 7),
        'update_interval' => env('WEATHER_UPDATE_INTERVAL', 3600), // seconds
    ],

];
