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
        Schema::create('distribution_operational_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('distribution_id')
                ->constrained('distributions')
                ->cascadeOnDelete();

            $table->foreignId('operational_item_id')
                ->constrained('operational_items')
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
        Schema::dropIfExists('distribution_operational_details');
    }
};