<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('studijny_program', function (Blueprint $table) {
        $table->id();
        $table->string('nazov');
        $table->string('skratka');
        $table->timestamps();
    });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
