<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbRequisitoVaga extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();

    Schema::create('tbRequisitoVaga', function(Blueprint $table){
      $table->increments('codRequisitoVaga');
      $table->boolean('obrigatoriedadeRequisitoVaga');
      $table->integer('codAdicional')->unsigned();
      $table->integer('codVaga')->unsigned();
      $table->timestamps();
    });

    Schema::table('tbRequisitoVaga', function($table){
      $table->foreign('codAdicional')->references('codAdicional')->on('tbAdicional');
      $table->foreign('codVaga')->references('codVaga')->on('tbVaga');
    });

    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::table('tbRequisitoVaga', function (Blueprint $table) {
        $table->dropForeign(['codAdicional']);
        $table->dropForeign(['codVaga']);
        $table->dropIfExists('tbRequisitoVaga');
      });
    Schema::enableForeignKeyConstraints();
  }
}
