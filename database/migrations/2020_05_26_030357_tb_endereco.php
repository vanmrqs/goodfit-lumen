<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbEndereco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbEndereco', function(Blueprint $table){
            $table->increments('codEndereco');
            $table->string('cepEndereco', 8);
            $table->string('logradouroEndereco', 200);
            $table->text('numeroEndereco', 5);
            $table->text('complementoEndereco')->nullable();
            $table->string('bairroEndereco', 50);
            $table->string('zonaEndereco', 50);
            $table->string('cidadeEndereco', 100);
            $table->string('estadoEndereco', 50);
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
        Schema::dropIfExists('tbEndereco');
    }
}
