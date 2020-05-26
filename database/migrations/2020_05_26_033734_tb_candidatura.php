<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbCandidatura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbCandidatura', function(Blueprint $table){
            $table->increments('codCandidatura');
            $table->timestamp('dataCandidatura');
            $table->integer('codCandidato')->unsigned();
            $table->integer('codVaga')->unsigned();
            $table->integer('codStatusCandidatura')->unsigned();
            $table->timestamps();
        });
      
        Schema::table('tbCandidatura', function($table){
            $table->foreign('codCandidato')->references('codCandidato')->on('tbCandidato');
            $table->foreign('codVaga')->references('codVaga')->on('tbVaga');
            $table->foreign('codStatusCandidatura')->references('codStatusCandidatura')->on('tbStatusCandidatura');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbCandidatura', function (Blueprint $table) {
            $table->dropForeign(['codCandidato']);
            $table->dropForeign(['codVaga']);
            $table->dropForeign(['codStatusCandidatura']);
            $table->dropIfExists('tbCandidatura');
        });
    }
}
