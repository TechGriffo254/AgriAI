<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('scientific_name')->nullable();
            $table->string('category'); // grains, vegetables, fruits, legumes, cash_crops
            $table->string('variety')->nullable();
            $table->text('description')->nullable();
            $table->integer('days_to_maturity')->nullable();
            $table->string('planting_season')->nullable();
            $table->string('harvest_season')->nullable();
            $table->decimal('optimal_temp_min', 5, 2)->nullable();
            $table->decimal('optimal_temp_max', 5, 2)->nullable();
            $table->decimal('water_requirement', 8, 2)->nullable(); // mm per growth cycle
            $table->string('soil_type_preference')->nullable();
            $table->decimal('ph_min', 3, 1)->nullable();
            $table->decimal('ph_max', 3, 1)->nullable();
            $table->string('image_path')->nullable();
            $table->json('growing_tips')->nullable();
            $table->json('common_pests')->nullable();
            $table->json('common_diseases')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'is_active']);
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crops');
    }
};
