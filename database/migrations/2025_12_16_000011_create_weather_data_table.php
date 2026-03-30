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
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->cascadeOnDelete();
            $table->dateTime('recorded_at');
            $table->string('data_type')->default('current'); // current, forecast, historical

            // Temperature
            $table->decimal('temperature', 5, 2)->nullable();
            $table->decimal('feels_like', 5, 2)->nullable();
            $table->decimal('temp_min', 5, 2)->nullable();
            $table->decimal('temp_max', 5, 2)->nullable();

            // Atmospheric conditions
            $table->integer('humidity')->nullable(); // percentage
            $table->decimal('pressure', 7, 2)->nullable(); // hPa
            $table->integer('visibility')->nullable(); // meters
            $table->integer('clouds')->nullable(); // percentage

            // Wind
            $table->decimal('wind_speed', 6, 2)->nullable(); // m/s or km/h
            $table->integer('wind_direction')->nullable(); // degrees
            $table->decimal('wind_gust', 6, 2)->nullable();

            // Precipitation
            $table->decimal('rain_1h', 6, 2)->nullable(); // mm
            $table->decimal('rain_3h', 6, 2)->nullable();
            $table->decimal('snow_1h', 6, 2)->nullable();
            $table->decimal('snow_3h', 6, 2)->nullable();

            // Conditions
            $table->string('weather_main')->nullable(); // Clear, Clouds, Rain, etc.
            $table->string('weather_description')->nullable();
            $table->string('weather_icon')->nullable();

            // Solar
            $table->dateTime('sunrise')->nullable();
            $table->dateTime('sunset')->nullable();
            $table->decimal('uv_index', 4, 2)->nullable();

            // AI Analysis
            $table->text('ai_insights')->nullable();
            $table->json('ai_recommendations')->nullable();

            $table->string('source')->nullable(); // API provider
            $table->json('raw_data')->nullable();
            $table->timestamps();

            $table->index(['farm_id', 'recorded_at']);
            $table->index(['data_type', 'recorded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_data');
    }
};
