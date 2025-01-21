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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id');
            //$table->json('data')->nullable();
            $table->smallInteger('status')->default(0)->nullable()->comment('0-rozpoczęty, 1-przedawniony, 2-zakończony, 3-anulowany');
            $table->dateTime('maxTime')->nullable();
            $table->boolean('learnMode')->default(false)->comment('Tryb nauki (błędne pytania zostają w puli pytań do odpowiedzi)');
            $table->timestamps();
            $table->dateTime('ended_at')->nullable();
            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
