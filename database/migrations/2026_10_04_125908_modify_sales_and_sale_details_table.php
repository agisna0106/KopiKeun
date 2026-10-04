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
        /*
         * Modify sales table
         */
        Schema::table('sales', function (Blueprint $table) {

            // Remove employee relationship
            $table->dropForeign(['employee_id']);
            $table->dropColumn('employee_id');

            // Add distribution relationship
            $table->foreignId('distribution_id')
                ->nullable()
                ->after('sale_source')
                ->constrained('distributions')
                ->nullOnDelete();
        });


        /*
         * Modify sale_details table
         */
        Schema::table('sale_details', function (Blueprint $table) {

            // Remove stored unit price
            $table->dropColumn('unit_price');

            // Change quantity from decimal to integer
            $table->unsignedInteger('quantity')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
         * Restore sale_details
         */
        Schema::table('sale_details', function (Blueprint $table) {

            $table->decimal('unit_price', 12, 2)
                ->after('quantity');

            $table->decimal('quantity', 12, 2)
                ->change();
        });


        /*
         * Restore sales
         */
        Schema::table('sales', function (Blueprint $table) {

            $table->dropForeign(['distribution_id']);
            $table->dropColumn('distribution_id');

            $table->foreignId('employee_id')
                ->nullable()
                ->after('sale_source')
                ->constrained('employees')
                ->nullOnDelete();
        });
    }
};
