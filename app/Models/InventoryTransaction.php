<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'user_id',
        'crop_cycle_id',
        'type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'unit_cost',
        'total_cost',
        'reference_number',
        'notes',
        'transaction_date',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'float',
            'quantity_before' => 'float',
            'quantity_after' => 'float',
            'unit_cost' => 'float',
            'total_cost' => 'float',
            'transaction_date' => 'date',
            'metadata' => 'array',
        ];
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cropCycle(): BelongsTo
    {
        return $this->belongsTo(CropCycle::class);
    }
}
