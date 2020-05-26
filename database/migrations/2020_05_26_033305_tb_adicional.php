<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbAdicional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbAdicional', function(Blueprint $table){
            $table->increments('codAdicional');
            $table->string('imagemAdicional');
            $table->string('nomeAdicional', 100)->unique();
            $table->integer('grauAdicional');
            $table->integer('codTipoAdicional')->unsigned();
            $table->timestamps();
        });

        Schema::table('tbAdicional', function($table){
              $table->foreign('codTipoAdicional')->references('codTipoAdicional')->on('tbTipoAdicional');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbAdicional');
    }
}
