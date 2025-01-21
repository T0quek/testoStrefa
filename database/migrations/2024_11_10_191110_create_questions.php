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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->boolean('deleted')->default(false);
            $table->json('data')->nullable();
            $table->integer('type')->comment('1: abcd, 2: multi abcd, 3: select, 4: value')->default(1);
            $table->text('image_path')->nullable();
            $table->unsignedBigInteger('set_id');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('previous_question_id')->nullable();
            $table->timestamps();

            $table->foreign('set_id')->references('id')->on('sets')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('previous_question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
