<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbRegimeContratacao extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();
    Schema::create('tbRegimeContratacao', function(Blueprint $table){
      $table->increments('codRegimeContratacao');
      $table->string('nomeRegimeContratacao', 70)->unique();
      $table->timestamps();
    });
    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('tbRegimeContratacao');
    Schema::enableForeignKeyConstraints();
  }
}
