<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePosicaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posicao', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 80);
            $table->string('descricao', 250);
            $table->timestamps();
        });
        DB::table('posicao')->insert([
            'nome' => 'Goleiro',
            'descricao' => 'Nada descrito...'
        ]);
        DB::table('posicao')->insert([
            'nome' => 'Defensor',
            'descricao' => 'Nada descrito...'
        ]);
        DB::table('posicao')->insert([
            'nome' => 'Lateral',
            'descricao' => 'Nada descrito...'
        ]);
        DB::table('posicao')->insert([
            'nome' => 'Volante',
            'descricao' => 'Nada descrito...'
        ]);
        DB::table('posicao')->insert([
            'nome' => 'Meia',
            'descricao' => 'Nada descrito...'
        ]);
        DB::table('posicao')->insert([
            'nome' => 'Atacante',
            'descricao' => 'Nada descrito...'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posicao');
    }
}
