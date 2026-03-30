<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherData extends Model
{
    use HasFactory;

    protected $table = 'weather_data';

    protected $fillable = [
        'farm_id',
        'recorded_at',
        'data_type',
        'temperature',
        'feels_like',
        'temp_min',
        'temp_max',
        'humidity',
        'pressure',
        'visibility',
        'clouds',
        'wind_speed',
        'wind_direction',
        'wind_gust',
        'rain_1h',
        'rain_3h',
        'snow_1h',
        'snow_3h',
        'weather_main',
        'weather_description',
        'weather_icon',
        'sunrise',
        'sunset',
        'uv_index',
        'ai_insights',
        'ai_recommendations',
        'source',
        'raw_data',
    ];

    protected function casts(): array
    {
        return [
            'recorded_at' => 'datetime',
            'temperature' => 'float',
            'feels_like' => 'float',
            'temp_min' => 'float',
            'temp_max' => 'float',
            'humidity' => 'integer',
            'pressure' => 'float',
            'visibility' => 'integer',
            'clouds' => 'integer',
            'wind_speed' => 'float',
            'wind_direction' => 'integer',
            'wind_gust' => 'float',
            'rain_1h' => 'float',
            'rain_3h' => 'float',
            'snow_1h' => 'float',
            'snow_3h' => 'float',
            'sunrise' => 'datetime',
            'sunset' => 'datetime',
            'uv_index' => 'float',
            'ai_recommendations' => 'array',
            'raw_data' => 'array',
        ];
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
}
