<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('tbEmpresa', function (Blueprint $table) {
        $table->dropForeign(['codUsuario']);
        $table->dropIfExists('tbEmpresa');
      });
    }
}
