<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('phone_number')->unique();
            $table->integer('city');
            $table->string('address')->nullable();
            $table->string('verification_code');
            $table->tinyInteger('role');
            $table->timestamp('email_verified_at')->nullable();
            $table->json('product_id')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
