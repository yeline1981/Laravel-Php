<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ViewSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW vista_solicitudes AS
        (
           select  presupuestar.*, to_char(presupuestar.created_at, 'dd-mm-yyyy') as fecha, tipo_trabajo.tipo as tipotrabajo, grupos_tipos.grupo, grupos_tipos.friendly_name
           from presupuestar, tipo_trabajo, grupos_tipos
           where presupuestar.idtipo = tipo_trabajo.id
             and tipo_trabajo.idgrupo = grupos_tipos.id
             order by presupuestar.id desc
        )
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vista_solicitudes');
    }
}
