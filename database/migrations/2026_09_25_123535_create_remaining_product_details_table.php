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
        Schema::create('remaining_product_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('remaining_product_id')
                ->constrained('remaining_products')
                ->cascadeOnDelete();

            $table->foreignId('base_drink_id')
                ->constrained('base_drinks')
                ->restrictOnDelete();

            $table->decimal('quantity', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remaining_product_details');
    }
};
