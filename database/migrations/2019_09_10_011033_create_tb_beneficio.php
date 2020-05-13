<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbBeneficio extends Migration
{
  public function up(){
    Schema::disableForeignKeyConstraints();

    Schema::create('tbBeneficio', function(Blueprint $table){
      $table->increments('codBeneficio');
      $table->string('nomeBeneficio', 150);
      $table->integer('codVaga')->unsigned();
      $table->timestamps();
    });

    Schema::table('tbBeneficio', function($table){
      $table->foreign('codVaga')->references('codVaga')->on('tbVaga');
    });

    Schema::enableForeignKeyConstraints();
  }

  public function down(){
    Schema::disableForeignKeyConstraints();
    Schema::table('tbBeneficio', function (Blueprint $table) {
        $table->dropForeign(['codVaga']);
        $table->dropIfExists('tbBeneficio');
      });
    Schema::enableForeignKeyConstraints();
  }
}
