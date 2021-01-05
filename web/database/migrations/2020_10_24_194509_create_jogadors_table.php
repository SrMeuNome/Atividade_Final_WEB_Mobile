<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJogadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogador', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_posicao');
            $table->unsignedBigInteger('id_clube');
            $table->string('nome', 100);
            $table->date('data_nasc');
            $table->foreign('id_posicao')->references('id')->on('posicao');
            $table->foreign('id_clube')->references('id')->on('clube');
            $table->boolean('is_possui');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jogador');
    }
}
