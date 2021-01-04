<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapelesTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papeles_trabajos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idpapel');
            $table->foreign('idpapel')->references('id')->on('papeles');
            $table->integer('idtipo');
            $table->foreign('idtipo')->references('id')->on('tipo_trabajo');
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
        Schema::dropIfExists('papeles_trabajos');
    }
}
