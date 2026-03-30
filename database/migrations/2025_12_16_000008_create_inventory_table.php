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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('farm_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('category'); // seeds, fertilizers, pesticides, equipment, tools, fuel, other
            $table->string('subcategory')->nullable();
            $table->text('description')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('quantity', 12, 2)->default(0);
            $table->string('unit'); // kg, liters, bags, pieces, etc.
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->string('currency')->default('USD');
            $table->decimal('reorder_level', 12, 2)->nullable();
            $table->string('storage_location')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('supplier')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'category']);
            $table->index(['farm_id', 'is_active']);
            $table->unique(['user_id', 'sku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
