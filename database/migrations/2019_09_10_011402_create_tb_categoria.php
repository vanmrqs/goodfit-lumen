<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbCategoria extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();
    Schema::create('tbCategoria', function(Blueprint $table){
      $table->increments('codCategoria');
      $table->text('imagemCategoria');
      $table->string('nomeCategoria', 100)->unique();
      $table->timestamps();
    });
    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('tbCategoria');
    Schema::enableForeignKeyConstraints();
  }
}
