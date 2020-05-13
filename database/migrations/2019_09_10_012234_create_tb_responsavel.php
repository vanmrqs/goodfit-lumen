<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbResponsavel extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();

    Schema::create('tbResponsavel', function(Blueprint $table){
      $table->increments('codResponsavel');
      $table->string('nomeResponsavel', 150);
      $table->integer('codCandidato')->unsigned();
      $table->timestamps();
    });

    Schema::table('tbResponsavel', function($table){
      $table->foreign('codCandidato')->references('codCandidato')->on('tbCandidato');
    });

    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::table('tbResponsavel', function (Blueprint $table) {
        $table->dropForeign(['codCandidato']);
        $table->dropIfExists('tbResponsavel');
      });
    Schema::enableForeignKeyConstraints();
  }
}
