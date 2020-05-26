<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbUsuario', function(Blueprint $table){
            $table->increments('codUsuario');
            $table->string('fotoUsuario')->default('perfil.png');
            $table->string('loginUsuario', 50)->unique();
            $table->text('password');
            $table->string('email', 150)->unique();
            $table->integer('codNivelUsuario')->unsigned();
            $table->integer('codEndereco')->unsigned()->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
          });
      
          Schema::table('tbUsuario', function($table){
            $table->foreign('codNivelUsuario')->references('codNivelUsuario')->on('tbNivelUsuario');
            $table->foreign('codEndereco')->references('codEndereco')->on('tbEndereco');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbUsuario', function (Blueprint $table) {
            $table->dropForeign(['codNivelUsuario']);
            $table->dropForeign(['codEndereco']);
            $table->dropIfExists('tbUsuario');
          });
    }
}
