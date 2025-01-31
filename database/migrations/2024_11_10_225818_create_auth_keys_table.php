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
        Schema::create('auth_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->nullable()->comment("xxxxx-xxxxx-xxxxx");
            $table->unsignedBigInteger('creator_id');
            $table->json('options')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_keys');
    }
};
