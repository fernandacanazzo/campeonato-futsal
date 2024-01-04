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
        Schema::create('classificacao', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('time_id');
            $table->unsignedSmallInteger('pontos');
            $table->unsignedSmallInteger('qtd_gols');
            $table->foreign('time_id')->references('id')->on('times');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classificacao');
    }
};
