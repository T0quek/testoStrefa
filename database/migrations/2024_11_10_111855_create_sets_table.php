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
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->boolean('deleted')->default(false);
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('creator_id');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sets');
    }
};
