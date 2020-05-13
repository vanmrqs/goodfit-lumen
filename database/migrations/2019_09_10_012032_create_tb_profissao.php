<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbProfissao extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();

    Schema::create('tbProfissao', function(Blueprint $table){
      $table->increments('codProfissao');
      $table->string('nomeProfissao', 100)->unique();
      $table->integer('codCategoria')->unsigned();
      $table->timestamps();
    });
    Schema::table('tbProfissao', function($table){
      $table->foreign('codCategoria')->references('codCategoria')->on('tbCategoria');
    });
    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::table('tbProfissao', function (Blueprint $table) {
        $table->dropForeign(['codCategoria']);
        $table->dropIfExists('tbProfissao');
      });
    Schema::enableForeignKeyConstraints();
  }
}
