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
        Schema::create('firma', function (Blueprint $table) {
            $table->id();
            $table->string("nazov_firmy");
            $table->integer("IČO");
            $table->string("meno_kontaktnej_osoby");
            $table->string("priezvisko_kontaktnej_osoby");
            $table->string("email");
            $table->string("tel_cislo");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('firma');
    }
};
