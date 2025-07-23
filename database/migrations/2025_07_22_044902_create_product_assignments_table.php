<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_assignments', function (Blueprint $table) {
            $table->id('assignment_id');
            $table->string('product_ref_id');
            $table->string('customer_ref_id');
            $table->boolean('status')->default(1);
            $table->timestamp('assigned_at');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('product_ref_id')->references('product_ref_id')->on('products')->onDelete('cascade');
            $table->foreign('customer_ref_id')->references('customer_ref_id')->on('customers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_assignments');
    }
};
