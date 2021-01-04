<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TipoTrabajo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_trabajo', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('tipo')->unique();
            $table->integer('idgrupo');
            $table->foreign('idgrupo')->references('id')->on('grupos_tipos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_trabajo');
    }
}
