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
        Schema::create('predmety', function (Blueprint $table) {
            $table->id();
            $table->string("nazov");
            $table->string("skratka");
            $table->unsignedBigInteger('studijny_program_id');
            $table->foreign('studijny_program_id')->references('id')->on('studijny_program')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predmety');
    }
};
