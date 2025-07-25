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
            $table->boolean('status')->default(1)->after('contact_number'); // or after any relevant column
        });

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('description');
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
