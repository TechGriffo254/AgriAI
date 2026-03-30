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
        Schema::create('irrigation_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->cascadeOnDelete();
            $table->foreignId('crop_cycle_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('type')->default('manual'); // manual, scheduled, ai_recommended
            $table->string('method')->nullable(); // drip, sprinkler, flood, etc.
            $table->decimal('water_amount', 10, 2)->nullable();
            $table->string('water_unit')->default('liters');
            $table->integer('duration_minutes')->nullable();
            $table->time('scheduled_time')->nullable();
            $table->json('days_of_week')->nullable(); // [1,2,3,4,5,6,7] for daily
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('ai_reasoning')->nullable(); // If AI recommended
            $table->dateTime('last_run_at')->nullable();
            $table->dateTime('next_run_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['farm_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('irrigation_schedules');
    }
};
