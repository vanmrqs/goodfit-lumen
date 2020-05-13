<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbNivelUsuario extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();
    Schema::create('tbNivelUsuario', function(Blueprint $table){
      $table->increments('codNivelUsuario');
      $table->string('nomeNivelUsuario', 50)->unique();
      $table->timestamps();
    });
    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('tbNivelUsuario');
    Schema::enableForeignKeyConstraints();
  }
}
