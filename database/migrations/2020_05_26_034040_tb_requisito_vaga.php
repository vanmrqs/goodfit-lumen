<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbRequisitoVaga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbRequisitoVaga', function (Blueprint $table) {
            $table->dropForeign(['codAdicional']);
            $table->dropForeign(['codVaga']);
            $table->dropIfExists('tbRequisitoVaga');
        });
    }
}
