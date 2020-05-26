<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbBeneficio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbBeneficio', function(Blueprint $table){
            $table->increments('codBeneficio');
            $table->string('nomeBeneficio', 150);
            $table->integer('codVaga')->unsigned();
            $table->timestamps();
        });
      
        Schema::table('tbBeneficio', function($table){
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
        Schema::table('tbBeneficio', function (Blueprint $table) {
            $table->dropForeign(['codVaga']);
            $table->dropIfExists('tbBeneficio');
        });
    }
}
