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
        Schema::create('base_drinks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('bottle_capacity_ml', 8, 2)->default(1200);
            $table->decimal('standard_serving_ml', 8, 2);
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minuman_dasars');
    }
};
