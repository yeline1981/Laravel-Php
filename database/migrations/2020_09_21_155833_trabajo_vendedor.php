<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TrabajoVendedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajo_vendedor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idtrabajo');
            $table->integer('idvendedor');
            $table->unique(['idtrabajo', 'idvendedor']);
            $table->foreign('idtrabajo')->references('id')->on('trabajos')->onDelete('cascade');
            $table->foreign('idvendedor')->references('id')->on('usuarios')->onDelete('cascade');
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
        Schema::dropIfExists('trabajo_vendedor');
    }
}
