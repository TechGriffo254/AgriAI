<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'farm_id',
        'crop_cycle_id',
        'category',
        'subcategory',
        'description',
        'amount',
        'currency',
        'income_date',
        'buyer',
        'quantity',
        'quantity_unit',
        'unit_price',
        'payment_method',
        'payment_status',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'float',
            'income_date' => 'date',
            'quantity' => 'float',
            'unit_price' => 'float',
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
