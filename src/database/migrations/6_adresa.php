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
        Schema::create('adresa', function (Blueprint $table) {
            $table->id();
            $table->string("mesto");
            $table->integer("PSČ");
            $table->string("ulica");
            $table->string("č_domu");
            $table->unsignedBigInteger('firma_id');
            $table->foreign('firma_id')->references('id')->on('firma')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adresa');
    }
};
