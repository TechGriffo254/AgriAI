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
        Schema::create('crop_cycles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->cascadeOnDelete();
            $table->foreignId('crop_id')->constrained()->cascadeOnDelete();
            $table->string('name')->nullable(); // Custom name for this cycle
            $table->string('field_section')->nullable(); // Which section of the farm
            $table->decimal('area', 10, 2)->nullable(); // Area planted
            $table->string('area_unit')->default('hectares');
            $table->date('planting_date');
            $table->date('expected_harvest_date')->nullable();
            $table->date('actual_harvest_date')->nullable();
            $table->string('status')->default('planned'); // planned, planted, growing, harvesting, completed, failed
            $table->string('seed_source')->nullable();
            $table->string('seed_variety')->nullable();
            $table->decimal('seed_quantity', 10, 2)->nullable();
            $table->string('seed_unit')->nullable();
            $table->decimal('expected_yield', 10, 2)->nullable();
            $table->decimal('actual_yield', 10, 2)->nullable();
            $table->string('yield_unit')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['farm_id', 'status']);
            $table->index(['crop_id', 'planting_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_cycles');
    }
};
