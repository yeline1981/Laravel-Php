<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grupos_tipos')->insert(['grupo' => 'Tarjetas', 'friendly_name' => 'Tarjetas']);
        DB::table('grupos_tipos')->insert(['grupo' => 'Afiches',  'friendly_name' => 'Afiches']);
        DB::table('grupos_tipos')->insert(['grupo' => 'Folletos',  'friendly_name' => 'Folletos']);
        DB::table('grupos_tipos')->insert(['grupo' => 'Imprenta_Autorizada',  'friendly_name' => 'Imprenta Autorizada']);
        DB::table('grupos_tipos')->insert(['grupo' => 'Talonarios',  'friendly_name' => 'Talonarios']);
        DB::table('grupos_tipos')->insert(['grupo' => 'Papeleria_Empresarial',  'friendly_name' => 'Papelería Empresarial']);
        DB::table('grupos_tipos')->insert(['grupo' => 'Adhesivos',  'friendly_name' => 'Adhesivos']);
        DB::table('grupos_tipos')->insert(['grupo' => 'Libros_Catalogos',  'friendly_name' => 'Libros/Catálogos']);

        DB::table('grupos_tipos')->insert(['grupo' => 'Lonas_Impresas',  'friendly_name' => 'Lonas Impresas']);
        DB::table('grupos_tipos')->insert(['grupo' => 'Almanaques',  'friendly_name' => 'Almanaques']);

        DB::table('grupos_tipos')->insert(['grupo' => 'Imanes',  'friendly_name' => 'Imanes']);
         /*
        DB::table('grupos_tipos')->insert(['grupo' => 'Planos',  'friendly_name' => 'Planos']);
        */

        DB::table('tipo_trabajo')->insert(['idgrupo' => 1, 'tipo' => 'Tarjeta de Presentación']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 1, 'tipo' => 'Postales']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 1, 'tipo' => 'Invitaciones']);

        DB::table('tipo_trabajo')->insert(['idgrupo' => 2, 'tipo' => 'Afiches']);

        DB::table('tipo_trabajo')->insert(['idgrupo' => 3, 'tipo' => 'Volantes']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 3, 'tipo' => 'Dípticos']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 3, 'tipo' => 'Trípticos']);

        DB::table('tipo_trabajo')->insert(['idgrupo' => 4, 'tipo' => 'Facturas crédito']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 4, 'tipo' => 'Boletas contado']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 4, 'tipo' => 'Recibos']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 4, 'tipo' => 'Remitos']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 4, 'tipo' => 'Devolución de contado']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 4, 'tipo' => 'Notas de créditos']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 4, 'tipo' => 'Hojas Prenumeradas']);

        DB::table('tipo_trabajo')->insert(['idgrupo' => 5, 'tipo' => 'Rifas/sorteos']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 5, 'tipo' => 'Tickets']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 5, 'tipo' => 'Entradas']);


        DB::table('tipo_trabajo')->insert(['idgrupo' => 6, 'tipo' => 'Sobres']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 6, 'tipo' => 'Hojas Membretadas']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 6, 'tipo' => 'Carpetas']);

        DB::table('tipo_trabajo')->insert(['idgrupo' => 7, 'tipo' => 'Adhesivo']);


        DB::table('tipo_trabajo')->insert(['idgrupo' => 8, 'tipo' => 'Catálogos']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 8, 'tipo' => 'Libros']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 8, 'tipo' => 'Revistas']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 8, 'tipo' => 'Mailing']);

        DB::table('tipo_trabajo')->insert(['idgrupo' => 8, 'tipo' => 'Cuadernos']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 8, 'tipo' => 'Agendas']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 8, 'tipo' => 'Blocks']);

        DB::table('tipo_trabajo')->insert(['idgrupo' => 9, 'tipo' => 'RollOn']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 9, 'tipo' => 'Banner']);

        DB::table('tipo_trabajo')->insert(['idgrupo' => 10, 'tipo' => 'Bolsillo']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 10, 'tipo' => 'Pared']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 10, 'tipo' => 'Escritorio']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 10, 'tipo' => 'Carpa para Escritorio']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 10, 'tipo' => 'Con Rulos Para Escritorio']);
        DB::table('tipo_trabajo')->insert(['idgrupo' => 10, 'tipo' => 'Con Rulos Para Pared']);

        DB::table('tipo_trabajo')->insert(['idgrupo' => 11, 'tipo' => 'Imanes']);
/*
        DB::table('tipo_trabajo')->insert(['idgrupo' => 12, 'tipo' => 'Plano']);
*/

        DB::table('usuarios')->insert(['nombre' => 'Administrador', 'login' => 'admin', 'password' => '$2y$10$Yjt8pEFVUC7Q9NiBdRnbkOu8FpBMnHSojJIpgeIbYl9/kNxbVL5Si', 'role' => 'System']);

        DB::table('estados')->insert(['id' => 1, 'estado' => 'Corregir Diseño']);
        DB::table('estados')->insert(['id' => 2, 'estado' => 'Revisión Cliente']);
        DB::table('estados')->insert(['id' => 3, 'estado' => 'Aprobado']);
        DB::table('estados')->insert(['id' => 4, 'estado' => 'Listo']);
        DB::table('estados')->insert(['id' => 5, 'estado' => 'Entregado']);
        DB::table('estados')->insert(['id' => 6, 'estado' => 'Cancelado']);

        DB::table('clientes')->insert(['id' => '11111111', 'nombre' => 'Genérico', 'telefono' => '00000000']);


        DB::table('categoria_facturacion')->insert(['categoria' => 'Diseño Gráfico']);
        DB::table('categoria_facturacion')->insert(['categoria' => 'Imprenta']);
        DB::table('categoria_facturacion')->insert(['categoria' => 'Publicidad']);
        DB::table('categoria_facturacion')->insert(['categoria' => 'Web']);




    }
}
