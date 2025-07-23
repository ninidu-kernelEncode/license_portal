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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('customer_ref_id', 255)->unique()->after('customer_name');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('product_ref_id', 255)->unique()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers_and_products_tables', function (Blueprint $table) {
            //
        });
    }
};
