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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // who triggered the log
            $table->string('action'); // e.g., "created user", "deleted invoice"
            $table->text('description')->nullable(); // more details
            $table->string('model')->nullable(); // related model (e.g., 'User')
            $table->unsignedBigInteger('model_id')->nullable(); // related model ID
            $table->ipAddress('ip_address')->nullable(); // user's IP
            $table->string('user_agent')->nullable(); // browser info
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
