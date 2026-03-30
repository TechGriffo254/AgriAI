<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'farm_id',
        'crop_cycle_id',
        'title',
        'description',
        'category',
        'priority',
        'status',
        'due_date',
        'due_time',
        'completed_at',
        'is_recurring',
        'recurrence_pattern',
        'recurrence_config',
        'reminder_enabled',
        'reminder_minutes_before',
        'reminder_sent_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'due_time' => 'string',
            'completed_at' => 'datetime',
            'is_recurring' => 'boolean',
            'recurrence_config' => 'array',
            'reminder_enabled' => 'boolean',
            'reminder_minutes_before' => 'integer',
            'reminder_sent_at' => 'datetime',
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
}
