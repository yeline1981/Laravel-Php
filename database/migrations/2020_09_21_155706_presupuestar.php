<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Presupuestar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('idtipo');
            $table->float('precio')->nullable();
            $table->float('iva')->nullable();
            $table->float('total')->nullable();
            $table->integer('cantidad');
            $table->boolean('numerado')->nullable();
            $table->integer('desde')->nullable();
            $table->integer('hasta')->nullable();
            $table->enum('unidad', ['Unidades', 'Números', 'Libretas'])->default('Unidades');
            $table->text('detalles')->nullable();
            $table->enum('diseno', ['Diseñar', 'No Diseñar', 'Reimprimir']);
            $table->string('papel');
            $table->foreign('papel')->references('papel')->on('papeles');
            $table->string('formato', 160);
            $table->string('frente', 160);
            $table->string('dorso', 160)->nullable();
            $table->string('contenido', 160);
            $table->string('recubrimiento', 160)->nullable();
            $table->string('tapa', 160)->nullable();
            $table->string('sangrado', 160)->nullable();
            $table->string('encuadernado', 160)->nullable();
            $table->tinyInteger('vias')->default(1);
            $table->tinyInteger('partes')->default(1);

            $table->foreign('idtipo')->references('id')->on('tipo_trabajo');
            $table->boolean('terciar')->default(false);

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('presupuestar');
    }
}
