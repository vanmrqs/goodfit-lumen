<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbEmpresa extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();

    Schema::create('tbEmpresa', function(Blueprint $table){
      $table->increments('codEmpresa');
      $table->string('razaoSocialEmpresa', 200);
      $table->string('nomeFantasiaEmpresa', 200);
      $table->string('cnpjEmpresa', 14)->unique();
      $table->integer('codUsuario')->unsigned();
      $table->timestamps();
    });

    Schema::table('tbEmpresa', function($table){
      $table->foreign('codUsuario')->references('codUsuario')->on('tbUsuario');
    });

    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::table('tbEmpresa', function (Blueprint $table) {
        $table->dropForeign(['codUsuario']);
        $table->dropIfExists('tbEmpresa');
      });
    Schema::enableForeignKeyConstraints();
  }
}
