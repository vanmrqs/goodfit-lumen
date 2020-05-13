<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbAdicional extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();
    Schema::create('tbAdicional', function(Blueprint $table){
      $table->increments('codAdicional');
      $table->text('imagemAdicional');
      $table->string('nomeAdicional', 100)->unique();
      $table->integer('grauAdicional');
      $table->integer('codTipoAdicional')->unsigned();
      $table->timestamps();
    });
    Schema::table('tbAdicional', function($table){
        $table->foreign('codTipoAdicional')->references('codTipoAdicional')->on('tbTipoAdicional');
    });
    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('tbAdicional');
    Schema::enableForeignKeyConstraints();
  }
}
