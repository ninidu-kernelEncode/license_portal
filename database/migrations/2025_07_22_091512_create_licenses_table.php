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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id('license_id');
            $table->string('product_ref_id');
            $table->string('customer_ref_id');
            $table->string('license_key')->unique();
            $table->string('hash_algorithm');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['Active', 'Expired', 'Revoked']);
            $table->timestamps();

            $table->foreign('product_ref_id')->references('product_ref_id')->on('products')->onDelete('cascade');
            $table->foreign('customer_ref_id')->references('customer_ref_id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
