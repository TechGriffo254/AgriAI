<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CropCycle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'farm_id',
        'crop_id',
        'name',
        'field_section',
        'area',
        'area_unit',
        'planting_date',
        'expected_harvest_date',
        'actual_harvest_date',
        'status',
        'seed_source',
        'seed_variety',
        'seed_quantity',
        'seed_unit',
        'expected_yield',
        'actual_yield',
        'yield_unit',
        'notes',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'area' => 'float',
            'planting_date' => 'date',
            'expected_harvest_date' => 'date',
            'actual_harvest_date' => 'date',
            'seed_quantity' => 'float',
            'expected_yield' => 'float',
            'actual_yield' => 'float',
            'metadata' => 'array',
        ];
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }

    public function irrigationSchedules(): HasMany
    {
        return $this->hasMany(IrrigationSchedule::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class);
    }

    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function pestDiagnoses(): HasMany
    {
        return $this->hasMany(PestDiagnosis::class);
    }
}
