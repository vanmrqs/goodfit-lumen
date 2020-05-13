<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbTipoAdicional extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();
    Schema::create('tbTipoAdicional', function(Blueprint $table){
      $table->increments('codTipoAdicional');
      $table->string('nomeTipoAdicional', 100)->unique();
      $table->boolean('escalonavelTipoAdicional');
      $table->timestamps();
    });
    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('tbTipoAdicional');
    Schema::enableForeignKeyConstraints();
  }
}
