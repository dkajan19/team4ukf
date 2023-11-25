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
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('pouzivatel')->onDelete('cascade');
            $table->unsignedBigInteger('veduci_pracoviska_id');
            $table->foreign('veduci_pracoviska_id')->references('id')->on('pouzivatel')->onDelete('cascade');
            $table->unsignedBigInteger('pracovnik_fpvai_id');
            $table->foreign('pracovnik_fpvai_id')->references('id')->on('pouzivatel')->onDelete('cascade');
            $table->unsignedBigInteger('kontaktna_osoba_id');
            $table->foreign('kontaktna_osoba_id')->references('id')->on('pouzivatel')->onDelete('cascade');
            $table->unsignedBigInteger('dokumenty_id');
            $table->foreign('dokumenty_id')->references('id')->on('dokumenty')->onDelete('cascade');
            $table->unsignedBigInteger('predmety_id');
            $table->foreign('predmety_id')->references('id')->on('predmety')->onDelete('cascade');
            $table->unsignedBigInteger('zmluva_id')->unique();
            $table->foreign('zmluva_id')->references('id')->on('zmluva')->onDelete('cascade');
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
