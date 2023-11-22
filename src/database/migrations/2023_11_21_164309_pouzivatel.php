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
        Schema::create('pouzivatel', function (Blueprint $table) {
            $table->id();
            $table->string("meno");
            $table->string("priezvisko");
            $table->string("tel_cislo");
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('rola_pouzivatela_id');
            $table->foreign('rola_pouzivatela_id')->references('id')->on('rola_pouzivatela')->onDelete('cascade');
            $table->unsignedBigInteger('firma_id')->nullable();
            $table->foreign('firma_id')->references('id')->on('firma')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pouzivatel');
    }
};