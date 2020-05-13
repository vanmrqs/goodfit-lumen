<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbStatusCandidatura extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();
    Schema::create('tbStatusCandidatura', function(Blueprint $table){
      $table->increments('codStatusCandidatura');
      $table->string('nomeStatusCandidatura', 50)->unique();
      $table->timestamps();
    });
    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('tbStatusCandidatura');
    Schema::enableForeignKeyConstraints();
  }
}
