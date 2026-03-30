<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoilTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'sample_location',
        'test_date',
        'lab_name',
        'lab_reference',
        'nitrogen',
        'phosphorus',
        'potassium',
        'calcium',
        'magnesium',
        'sulfur',
        'iron',
        'manganese',
        'zinc',
        'copper',
        'boron',
        'ph',
        'organic_matter',
        'cec',
        'texture',
        'moisture_content',
        'ai_interpretation',
        'ai_recommendations',
        'ai_analyzed_at',
        'report_path',
        'notes',
        'raw_data',
    ];

    protected function casts(): array
    {
        return [
            'test_date' => 'date',
            'nitrogen' => 'float',
            'phosphorus' => 'float',
            'potassium' => 'float',
            'calcium' => 'float',
            'magnesium' => 'float',
            'sulfur' => 'float',
            'iron' => 'float',
            'manganese' => 'float',
            'zinc' => 'float',
            'copper' => 'float',
            'boron' => 'float',
            'ph' => 'float',
            'organic_matter' => 'float',
            'cec' => 'float',
            'moisture_content' => 'float',
            'ai_recommendations' => 'array',
            'ai_analyzed_at' => 'datetime',
            'raw_data' => 'array',
        ];
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
}
