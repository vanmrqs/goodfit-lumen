<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbCargoCurriculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbCargoCurriculo', function (Blueprint $table) {
            $table->bigIncrements('codCargoCurriculo');
            $table->integer('codCategoria')->unsigned();
            $table->integer('codCurriculo')->unsigned();
            $table->timestamps();
        });
    
        Schema::table('tbCargoCurriculo', function($table){
            $table->foreign('codCategoria')->references('codCategoria')->on('tbCategoria');
            $table->foreign('codCurriculo')->references('codCurriculo')->on('tbCurriculo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbCargoCurriculo', function (Blueprint $table) {
            $table->dropForeign(['codCurriculo']);
            $table->dropIfExists('tbCargoCurriculo');
        });
    }
}
