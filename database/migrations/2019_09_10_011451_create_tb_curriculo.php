<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbCurriculo extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();

    Schema::create('tbCurriculo', function(Blueprint $table){
      $table->increments('codCurriculo');
      $table->text('videoCurriculo')->nullable();
      $table->text('descricaoCurriculo')->nullable();
      $table->integer('codCandidato')->unsigned();
      $table->timestamps();
    });

    Schema::table('tbCurriculo', function($table){
      $table->foreign('codCandidato')->references('codCandidato')->on('tbCandidato');
    });

    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::table('tbCurriculo', function (Blueprint $table) {
        $table->dropForeign(['codCandidato']);
        $table->dropIfExists('tbCurriculo');
      });
    Schema::enableForeignKeyConstraints();
  }
}
