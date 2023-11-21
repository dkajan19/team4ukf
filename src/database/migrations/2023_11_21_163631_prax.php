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
        Schema::create('prax', function (Blueprint $table) {
            $table->id();
            $table->string("popis_praxe");
            $table->date("datum_zaciatku");
            $table->date("datum_konca");
            $table->string('aktualny_stav')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prax');
    }
};
