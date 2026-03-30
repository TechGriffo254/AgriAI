<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IrrigationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'crop_cycle_id',
        'name',
        'type',
        'method',
        'water_amount',
        'water_unit',
        'duration_minutes',
        'scheduled_time',
        'days_of_week',
        'start_date',
        'end_date',
        'is_active',
        'ai_reasoning',
        'last_run_at',
        'next_run_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'water_amount' => 'float',
            'duration_minutes' => 'integer',
            'scheduled_time' => 'string',
            'days_of_week' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
            'last_run_at' => 'datetime',
            'next_run_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function cropCycle(): BelongsTo
    {
        return $this->belongsTo(CropCycle::class);
    }
}
