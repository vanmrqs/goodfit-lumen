<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbTipoAdicional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbTipoAdicional', function(Blueprint $table){
            $table->increments('codTipoAdicional');
            $table->string('nomeTipoAdicional', 100)->unique();
            $table->boolean('escalonavelTipoAdicional');
            $table->timestamps();
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbTipoAdicional');
    }
}
