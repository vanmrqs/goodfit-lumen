<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbCandidato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbCandidato', function(Blueprint $table){
            $table->increments('codCandidato');
            $table->string('nomeCandidato', 150);
            $table->string('cpfCandidato', 11)->unique();
            $table->string('rgCandidato', 20)->unique();
            $table->date('dataNascimentoCandidato');
            $table->integer('codUsuario')->unsigned();
            $table->timestamps();
        });

        Schema::table('tbCandidato', function($table){
            $table->foreign('codUsuario')->references('codUsuario')->on('tbUsuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbCandidato', function (Blueprint $table) {
            $table->dropForeign(['codUsuario']);
            $table->dropIfExists('tbCandidato');
        });
    }
}
