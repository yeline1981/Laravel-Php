<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ViewTrabajos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW view_trabajos AS
         (
            select b.*, usuarios.nombre as hecho
            from (select a.*, trabajos_disenador.idusuario
                    from (select  trabajos.*, to_char(trabajos.created_at, 'dd-mm-yyyy') as fecha,
                        tipo_trabajo.tipo as tipotrabajo,
                        grupos_tipos.grupo, estados.estado, clientes.nombre as cliente,
                        usuarios.nombre as vendedor
                    from trabajos, tipo_trabajo, grupos_tipos, estados, clientes, trabajo_vendedor, usuarios
                    where trabajos.idtipo = tipo_trabajo.id
                    and tipo_trabajo.idgrupo = grupos_tipos.id
                    and estados.id = trabajos.idestado
                    and trabajos.idcliente = clientes.id
                    and trabajos.id = trabajo_vendedor.idtrabajo
                    and usuarios.id = trabajo_vendedor.idvendedor ) a
                left join trabajos_disenador on a.id = trabajos_disenador.idtrabajo) b
            left join usuarios on b.idusuario = usuarios.id
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
        DB::statement('DROP VIEW IF EXISTS view_trabajos');
    }
}
