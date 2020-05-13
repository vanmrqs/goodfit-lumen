<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbAdministrador extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();

    Schema::create('tbAdministrador', function(Blueprint $table){
      $table->increments('codAdministrador');
      $table->string('nomeAdministrador', 150);
      $table->string('cpfAdministrador', 11)->unique();
      $table->string('unidadeAdministrador', 50);
      $table->integer('codUsuario')->unsigned();
      $table->timestamps();
    });

    Schema::table('tbAdministrador', function($table){
      $table->foreign('codUsuario')->references('codUsuario')->on('tbUsuario');
    });

    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::table('tbAdministrador', function (Blueprint $table) {
        $table->dropForeign(['codUsuario']);
        $table->dropIfExists('tbAdministrador');
      });
    Schema::enableForeignKeyConstraints();
  }
}
