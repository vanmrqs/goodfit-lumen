<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbExperienciaProfissional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbExperienciaProfissional', function(Blueprint $table){
            $table->increments('codExperienciaProfissional');
            $table->string('empresaExperienciaProfissional');
            $table->text('descricaoExperienciaProfissional');
            $table->string('videoExperienciaProfissional');
            $table->boolean('isEmpregoAtualExperienciaProfissional');
            $table->integer('dataInicioExperienciaProfissional');
            $table->integer('dataFinalExperienciaProfissional')->nullable();
            $table->integer('codProfissao')->unsigned();
            $table->integer('codCurriculo')->unsigned();
            $table->timestamps();
        });

        Schema::table('tbExperienciaProfissional', function($table){
            $table->foreign('codProfissao')->references('codProfissao')->on('tbProfissao');
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
        Schema::table('tbExperienciaProfissional', function (Blueprint $table) {
            $table->dropForeign(['codProfissao']);
            $table->dropForeign(['codCurriculo']);
            $table->dropIfExists('tbExperienciaProfissional');
        });
    }
}
