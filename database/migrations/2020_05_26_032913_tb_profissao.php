<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbProfissao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbProfissao', function(Blueprint $table){
            $table->increments('codProfissao');
            $table->string('nomeProfissao', 100)->unique();
            $table->integer('codCategoria')->unsigned();
            $table->timestamps();
        });

        Schema::table('tbProfissao', function($table){
            $table->foreign('codCategoria')->references('codCategoria')->on('tbCategoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbProfissao', function (Blueprint $table) {
            $table->dropForeign(['codCategoria']);
            $table->dropIfExists('tbProfissao');
        });
    }
}
