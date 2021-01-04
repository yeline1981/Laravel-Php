<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CodigosFacturacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigos_facturacion', function (Blueprint $table) {
            $table->smallInteger('id')->primary();
            $table->string('descripcion')->unique();
            $table->integer('idcategoria');
            $table->foreign('idcategoria')->references('id')->on('categoria_facturacion');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codigos_facturacion');
    }
}
