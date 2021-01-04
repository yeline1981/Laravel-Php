<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TrabajosDisenador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos_disenador', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idtrabajo');
            $table->integer('idusuario');
            $table->unique(['idtrabajo', 'idusuario']);
            $table->foreign('idtrabajo')->references('id')->on('trabajos')->onDelete('cascade');
            $table->foreign('idusuario')->references('id')->on('usuarios')->onDelete('cascade');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajos_disenador');
    }
}
