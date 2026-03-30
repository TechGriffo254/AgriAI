<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PestDiagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'farm_id',
        'crop_cycle_id',
        'ai_query_id',
        'crop_name',
        'symptoms_description',
        'image_path',
        'additional_images',
        'diagnosis_type',
        'identified_issue',
        'scientific_name',
        'confidence_score',
        'severity',
        'description',
        'treatment_options',
        'prevention_measures',
        'additional_notes',
        'status',
        'analyzed_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'additional_images' => 'array',
            'confidence_score' => 'float',
            'treatment_options' => 'array',
            'prevention_measures' => 'array',
            'analyzed_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function cropCycle(): BelongsTo
    {
        return $this->belongsTo(CropCycle::class);
    }

    public function aiQuery(): BelongsTo
    {
        return $this->belongsTo(AIQuery::class);
    }
}
