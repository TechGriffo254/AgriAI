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
        Schema::create('pest_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('farm_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('crop_cycle_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('ai_query_id')->nullable()->constrained()->nullOnDelete();
            $table->string('crop_name')->nullable();
            $table->text('symptoms_description')->nullable();
            $table->string('image_path')->nullable();
            $table->json('additional_images')->nullable();

            // Diagnosis results
            $table->string('diagnosis_type')->nullable(); // pest, disease, deficiency, other
            $table->string('identified_issue')->nullable();
            $table->string('scientific_name')->nullable();
            $table->decimal('confidence_score', 5, 2)->nullable(); // 0-100
            $table->string('severity')->nullable(); // mild, moderate, severe, critical
            $table->text('description')->nullable();

            // AI Recommendations
            $table->json('treatment_options')->nullable();
            $table->json('prevention_measures')->nullable();
            $table->text('additional_notes')->nullable();

            $table->string('status')->default('pending'); // pending, analyzed, reviewed
            $table->dateTime('analyzed_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['farm_id', 'diagnosis_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pest_diagnoses');
    }
};
