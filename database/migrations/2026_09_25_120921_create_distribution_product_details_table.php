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
        Schema::create('distribution_product_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('distribution_id')
                ->constrained('distributions')
                ->cascadeOnDelete();

            $table->foreignId('base_drink_id')
                ->constrained('base_drinks')
                ->restrictOnDelete();

            $table->integer('quantity_distributed');
            $table->integer('quantity_returned')->default(0);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_product_details');
    }
};
