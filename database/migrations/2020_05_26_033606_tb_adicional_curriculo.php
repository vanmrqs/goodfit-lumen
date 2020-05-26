<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbAdicionalCurriculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbAdicionalCurriculo', function(Blueprint $table){
			$table->increments('codAdicionalCurriculo');
			$table->integer('codAdicional')->unsigned();
			$table->integer('codCurriculo')->unsigned();
			$table->timestamps();
		});

		Schema::table('tbAdicionalCurriculo', function($table){
			$table->foreign('codAdicional')->references('codAdicional')->on('tbAdicional');
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
        Schema::table('tbAdicionalCurriculo', function (Blueprint $table) {
            $table->dropForeign(['codAdicional']);
            $table->dropForeign(['codCurriculo']);
            $table->dropIfExists('tbAdicionalCurriculo');
        });
    }
}
