<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbUsuario extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();

    Schema::create('tbUsuario', function(Blueprint $table){
      $table->increments('codUsuario');
      $table->text('fotoUsuario')->default('perfil.png');
      $table->string('loginUsuario', 50)->unique();
      $table->text('password');
      $table->string('email', 150)->unique();
      $table->integer('codNivelUsuario')->unsigned();
      $table->integer('codEndereco')->unsigned()->nullable();
      $table->string('remember_token', 100)->nullable();
      $table->timestamps();
    });

    Schema::table('tbUsuario', function($table){
      $table->foreign('codNivelUsuario')->references('codNivelUsuario')->on('tbNivelUsuario');
      $table->foreign('codEndereco')->references('codEndereco')->on('tbEndereco');
    });

    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::table('tbUsuario', function (Blueprint $table) {
        $table->dropForeign(['codNivelUsuario']);
        $table->dropForeign(['codEndereco']);
        $table->dropIfExists('tbUsuario');
      });
    Schema::enableForeignKeyConstraints();
  }
}
