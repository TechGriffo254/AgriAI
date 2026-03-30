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
        Schema::create('market_prices', function (Blueprint $table) {
            $table->id();
            $table->string('commodity');
            $table->string('variety')->nullable();
            $table->string('market_name')->nullable();
            $table->string('location')->nullable();
            $table->string('country')->nullable();
            $table->decimal('price', 12, 2);
            $table->string('currency')->default('USD');
            $table->string('unit'); // per kg, per ton, per bag, etc.
            $table->decimal('price_min', 12, 2)->nullable();
            $table->decimal('price_max', 12, 2)->nullable();
            $table->decimal('price_change', 8, 2)->nullable();
            $table->decimal('price_change_percent', 5, 2)->nullable();
            $table->date('price_date');
            $table->string('data_source')->nullable();
            $table->string('quality_grade')->nullable();

            // AI Predictions
            $table->decimal('predicted_price_7d', 12, 2)->nullable();
            $table->decimal('predicted_price_30d', 12, 2)->nullable();
            $table->text('ai_analysis')->nullable();
            $table->dateTime('ai_analyzed_at')->nullable();

            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['commodity', 'price_date']);
            $table->index(['location', 'commodity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_prices');
    }
};
