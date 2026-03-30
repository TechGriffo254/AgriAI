<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'commodity',
        'variety',
        'market_name',
        'location',
        'country',
        'price',
        'currency',
        'unit',
        'price_min',
        'price_max',
        'price_change',
        'price_change_percent',
        'price_date',
        'data_source',
        'quality_grade',
        'predicted_price_7d',
        'predicted_price_30d',
        'ai_analysis',
        'ai_analyzed_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'float',
            'price_min' => 'float',
            'price_max' => 'float',
            'price_change' => 'float',
            'price_change_percent' => 'float',
            'price_date' => 'date',
            'predicted_price_7d' => 'float',
            'predicted_price_30d' => 'float',
            'ai_analyzed_at' => 'datetime',
            'metadata' => 'array',
        ];
    }
}
