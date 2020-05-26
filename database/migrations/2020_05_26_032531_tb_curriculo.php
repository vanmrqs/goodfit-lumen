<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbCurriculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbCurriculo', function(Blueprint $table){
            $table->increments('codCurriculo');
            $table->string('videoCurriculo')->nullable();
            $table->string('descricaoCurriculo')->nullable();
            $table->integer('codCandidato')->unsigned();
            $table->timestamps();
        });
      
        Schema::table('tbCurriculo', function($table){
            $table->foreign('codCandidato')->references('codCandidato')->on('tbCandidato');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbCurriculo', function (Blueprint $table) {
            $table->dropForeign(['codCandidato']);
            $table->dropIfExists('tbCurriculo');
        });
    }
}
