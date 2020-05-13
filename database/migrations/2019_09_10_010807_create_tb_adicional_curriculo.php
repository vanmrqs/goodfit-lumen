<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbAdicionalCurriculo extends Migration{
	public function up(){
		Schema::disableForeignKeyConstraints();

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

		Schema::enableForeignKeyConstraints();
	}

	public function down(){
		Schema::disableForeignKeyConstraints();
		Schema::table('tbAdicionalCurriculo', function (Blueprint $table) {
        $table->dropForeign(['codAdicional']);
        $table->dropForeign(['codCurriculo']);
        $table->dropIfExists('tbAdicionalCurriculo');
      });
		Schema::enableForeignKeyConstraints();
	}
}
