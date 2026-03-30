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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('farm_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('crop_cycle_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category'); // crop_sales, livestock, services, subsidies, other
            $table->string('subcategory')->nullable();
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->string('currency')->default('USD');
            $table->date('income_date');
            $table->string('buyer')->nullable();
            $table->decimal('quantity', 10, 2)->nullable();
            $table->string('quantity_unit')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('received'); // pending, received, partial
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'income_date']);
            $table->index(['farm_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
