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
        Schema::create('partidas', function (Blueprint $table) {

            $table->id();
            $table->timestamp('data_inicio')->nullable();
            $table->timestamp('data_termino')->nullable();
            $table->unsignedBigInteger('time_id_1');
            $table->unsignedBigInteger('time_id_2');            
            $table->unsignedTinyInteger('placar_time_id_1');
            $table->unsignedTinyInteger('placar_time_id_2');
            $table->foreign('time_id_1')->references('id')->on('times');
            $table->foreign('time_id_2')->references('id')->on('times');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};
