<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default LLM Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default LLM provider that will be used by the
    | application. You may set this to any of the providers defined below.
    |
    */

    'default' => env('LLM_PROVIDER', 'groq'),

    /*
    |--------------------------------------------------------------------------
    | Chat Provider (for text-only conversations)
    |--------------------------------------------------------------------------
    |
    | The provider to use for chat/text functionality. Groq is free and fast.
    |
    */

    'chat_provider' => env('LLM_CHAT_PROVIDER', 'groq'),

    /*
    |--------------------------------------------------------------------------
    | Vision Provider (for image analysis)
    |--------------------------------------------------------------------------
    |
    | The provider to use for vision/image analysis. Gemini is used for vision.
    |
    */

    'vision_provider' => env('LLM_VISION_PROVIDER', 'gemini'),

    /*
    |--------------------------------------------------------------------------
    | LLM Providers
    |--------------------------------------------------------------------------
    |
    | Here you may configure the providers for LLM services. You may even
    | configure multiple providers of the same type.
    |
    */

    'providers' => [

        'groq' => [
            'api_key' => env('GROQ_API_KEY'),
            'model' => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),
            'max_tokens' => env('GROQ_MAX_TOKENS', 8192),
            'temperature' => env('GROQ_TEMPERATURE', 0.7),
            'base_url' => 'https://api.groq.com/openai/v1',
        ],

        'gemini' => [
            'api_key' => env('GEMINI_API_KEY'),
            'model' => env('GEMINI_MODEL', 'gemini-2.0-flash'),
            'vision_model' => env('GEMINI_VISION_MODEL', 'gemini-2.0-flash'),
            'max_tokens' => env('GEMINI_MAX_TOKENS', 8192),
            'temperature' => env('GEMINI_TEMPERATURE', 0.7),
            'base_url' => 'https://generativelanguage.googleapis.com/v1beta',
        ],

        'openai' => [
            'api_key' => env('OPENAI_API_KEY'),
            'organization' => env('OPENAI_ORGANIZATION'),
            'model' => env('OPENAI_MODEL', 'gpt-4o'),
            'vision_model' => env('OPENAI_VISION_MODEL', 'gpt-4o'),
            'max_tokens' => env('OPENAI_MAX_TOKENS', 4096),
            'temperature' => env('OPENAI_TEMPERATURE', 0.7),
        ],

        'claude' => [
            'api_key' => env('ANTHROPIC_API_KEY'),
            'model' => env('ANTHROPIC_MODEL', 'claude-sonnet-4-20250514'),
            'vision_model' => env('ANTHROPIC_VISION_MODEL', 'claude-sonnet-4-20250514'),
            'max_tokens' => env('ANTHROPIC_MAX_TOKENS', 4096),
            'temperature' => env('ANTHROPIC_TEMPERATURE', 0.7),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for LLM requests to prevent abuse and manage
    | costs. These limits are per user.
    |
    */

    'rate_limits' => [
        'requests_per_minute' => env('LLM_RATE_LIMIT_PER_MINUTE', 20),
        'requests_per_day' => env('LLM_RATE_LIMIT_PER_DAY', 500),
        'tokens_per_day' => env('LLM_TOKENS_PER_DAY', 100000),
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Configure caching for LLM responses to reduce API calls and costs.
    |
    */

    'cache' => [
        'enabled' => env('LLM_CACHE_ENABLED', true),
        'ttl' => env('LLM_CACHE_TTL', 3600), // 1 hour
        'prefix' => 'llm_cache_',
    ],

    /*
    |--------------------------------------------------------------------------
    | System Prompts
    |--------------------------------------------------------------------------
    |
    | Default system prompts for different AI features.
    |
    */

    'prompts' => [
        'crop_advisor' => 'You are an expert agricultural advisor specializing in crop management. Provide detailed, practical advice based on the user\'s specific conditions including soil type, climate, and market factors. Always consider sustainable farming practices.',

        'pest_diagnosis' => 'You are an expert plant pathologist and entomologist. Analyze the provided information about plant symptoms or images to identify potential pests, diseases, or nutritional deficiencies. Provide specific treatment recommendations and preventive measures.',

        'weather_insights' => 'You are an agricultural meteorologist. Analyze weather data and patterns to provide actionable farming recommendations. Consider how weather conditions affect planting, irrigation, harvesting, and pest/disease pressure.',

        'market_intelligence' => 'You are an agricultural market analyst. Analyze market trends, pricing data, and supply/demand factors to provide insights on optimal selling times and price predictions. Consider local and regional market conditions.',

        'soil_analysis' => 'You are a soil scientist and agronomist. Interpret soil test results and provide specific fertilization recommendations. Consider crop requirements, soil health, and sustainable nutrient management practices.',

        'irrigation_advisor' => 'You are an irrigation specialist. Based on crop type, growth stage, soil conditions, and weather data, recommend optimal irrigation schedules. Prioritize water conservation while ensuring crop health.',

        'chat_assistant' => 'You are AgriAI, a helpful farming assistant with expertise in agriculture, crop management, livestock care, and farm business management. Provide practical, actionable advice tailored to the user\'s specific situation. Be conversational but professional.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Feature Flags
    |--------------------------------------------------------------------------
    |
    | Enable or disable specific AI features.
    |
    */

    'features' => [
        'crop_advisor' => env('FEATURE_CROP_ADVISOR', true),
        'pest_diagnosis' => env('FEATURE_PEST_DIAGNOSIS', true),
        'weather_insights' => env('FEATURE_WEATHER_INSIGHTS', true),
        'market_intelligence' => env('FEATURE_MARKET_INTELLIGENCE', true),
        'soil_analysis' => env('FEATURE_SOIL_ANALYSIS', true),
        'irrigation_advisor' => env('FEATURE_IRRIGATION_ADVISOR', true),
        'chat_assistant' => env('FEATURE_CHAT_ASSISTANT', true),
        'image_analysis' => env('FEATURE_IMAGE_ANALYSIS', true),
    ],

];
