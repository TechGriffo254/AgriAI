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
        Schema::create('soil_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->cascadeOnDelete();
            $table->string('sample_location')->nullable();
            $table->date('test_date');
            $table->string('lab_name')->nullable();
            $table->string('lab_reference')->nullable();

            // Primary nutrients
            $table->decimal('nitrogen', 8, 2)->nullable();
            $table->decimal('phosphorus', 8, 2)->nullable();
            $table->decimal('potassium', 8, 2)->nullable();

            // Secondary nutrients
            $table->decimal('calcium', 8, 2)->nullable();
            $table->decimal('magnesium', 8, 2)->nullable();
            $table->decimal('sulfur', 8, 2)->nullable();

            // Micronutrients
            $table->decimal('iron', 8, 2)->nullable();
            $table->decimal('manganese', 8, 2)->nullable();
            $table->decimal('zinc', 8, 2)->nullable();
            $table->decimal('copper', 8, 2)->nullable();
            $table->decimal('boron', 8, 2)->nullable();

            // Soil properties
            $table->decimal('ph', 4, 2)->nullable();
            $table->decimal('organic_matter', 5, 2)->nullable(); // percentage
            $table->decimal('cec', 8, 2)->nullable(); // Cation Exchange Capacity
            $table->string('texture')->nullable(); // sandy, loamy, clay, etc.
            $table->decimal('moisture_content', 5, 2)->nullable();

            // AI Analysis
            $table->text('ai_interpretation')->nullable();
            $table->json('ai_recommendations')->nullable();
            $table->dateTime('ai_analyzed_at')->nullable();

            $table->string('report_path')->nullable();
            $table->text('notes')->nullable();
            $table->json('raw_data')->nullable();
            $table->timestamps();

            $table->index(['farm_id', 'test_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soil_tests');
    }
};
