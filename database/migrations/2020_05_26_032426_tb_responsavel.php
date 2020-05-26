<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbResponsavel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbResponsavel', function(Blueprint $table){
            $table->increments('codResponsavel');
            $table->string('nomeResponsavel', 150);
            $table->integer('codCandidato')->unsigned();
            $table->timestamps();
        });
      
        Schema::table('tbResponsavel', function($table){
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
        Schema::table('tbResponsavel', function (Blueprint $table) {
            $table->dropForeign(['codCandidato']);
            $table->dropIfExists('tbResponsavel');
        });
    }
}
