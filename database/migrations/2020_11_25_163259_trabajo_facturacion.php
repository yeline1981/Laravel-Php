<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TrabajoFacturacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajo_facturacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idtrabajo');
            $table->integer('idcodigo');
            $table->unique(['idtrabajo', 'idcodigo']);
            $table->integer('cantidad');
            $table->foreign('idtrabajo')->references('id')->on('trabajos')->onDelete('cascade');
            $table->foreign('idcodigo')->references('id')->on('codigos_facturacion')->onDelete('cascade');
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
        Schema::dropIfExists('trabajo_facturacion');
    }
}
