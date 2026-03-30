<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Crop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'scientific_name',
        'category',
        'variety',
        'description',
        'days_to_maturity',
        'planting_season',
        'harvest_season',
        'optimal_temp_min',
        'optimal_temp_max',
        'water_requirement',
        'soil_type_preference',
        'ph_min',
        'ph_max',
        'image_path',
        'growing_tips',
        'common_pests',
        'common_diseases',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'days_to_maturity' => 'integer',
            'optimal_temp_min' => 'float',
            'optimal_temp_max' => 'float',
            'water_requirement' => 'float',
            'ph_min' => 'float',
            'ph_max' => 'float',
            'growing_tips' => 'array',
            'common_pests' => 'array',
            'common_diseases' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function cropCycles(): HasMany
    {
        return $this->hasMany(CropCycle::class);
    }
}
