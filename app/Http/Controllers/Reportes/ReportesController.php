<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trabajo;
use App\Models\Caja;
use DB;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function tendencia(Request $request){

        if (!$request->ajax()) return redirect('/');

        try{

            $vendidos = Trabajo::select(DB::raw('count(*) as valor, EXTRACT(MONTH FROM created_at) as mes, EXTRACT(YEAR FROM created_at) as ano'))
                                ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at) '))
                                ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at) '))
                                ->orderBy('ano', 'desc')
                                ->orderBy('mes', 'desc')
                                ->limit(12)
                                ->get();

            $importe = Caja::select(DB::raw('sum(ingresa) as valor, EXTRACT(MONTH FROM updated_at) as mes, EXTRACT(YEAR FROM updated_at) as ano'))
                                ->groupBy(DB::raw('EXTRACT(YEAR FROM updated_at) '))
                                ->groupBy(DB::raw('EXTRACT(MONTH FROM updated_at) '))
                                ->orderBy('ano', 'desc')
                                ->orderBy('mes', 'desc')
                                ->limit(12)
                                ->get();

             $vendidosCateg = DB::select('select cant, tipo from (
                                                            select count(*) as cant, idtipo
                                                                from trabajos
                                                                where created_at >= current_date - interval \'365 day\' group by idtipo ) a , tipo_trabajo
                                                                where tipo_trabajo.id = a.idtipo');

             return [
                 'importe' => $importe,
                 'vendidos' => $vendidos,
                 'categorias' => $vendidosCateg
             ];

         }
         catch (\Exception $e) {
             report($e);
             return response()->json([
                 'message' => $e->getMessage()
             ], 400);

         }
    }

    public function general(Request $request){

        if (!$request->ajax()) return redirect('/');

        try{
             $queryTipos = 'select  grupos_tipos.friendly_name as grupo, tipo_trabajo.tipo, total
                        from tipo_trabajo, grupos_tipos, ( select idtipo, count(*) as total from trabajos where idestado < 6 ';

             if ($request->filled('desde')){
                $queryTipos = $queryTipos . ' and created_at >= date(\'' . $request->desde . '\') ';
             }

             if ($request->filled('hasta')){
                $queryTipos = $queryTipos . ' and created_at <= date(\'' . $request->hasta . '\') ';
             }

             $queryTipos = $queryTipos . ' group by idtipo ) as c
                                            where tipo_trabajo.id = idtipo
                                            and grupos_tipos.id = tipo_trabajo.idgrupo order by grupo';

             $tipos = DB::select($queryTipos);

             $query = 'select  grupos_tipos.friendly_name as grupo, tipo_trabajo.tipo, total
                        from tipo_trabajo, grupos_tipos, ( select idtipo, sum(total) as total from trabajos where idestado < 6 ';

             if ($request->filled('desde')){
                $query = $query . ' and created_at >= date(\'' . $request->desde . '\') ';
             }

             if ($request->filled('hasta')){
                $query = $query . ' and created_at <= date(\'' . $request->hasta . '\') ';
             }

             $query = $query . ' group by idtipo ) as c
                                where tipo_trabajo.id = idtipo
                                and grupos_tipos.id = tipo_trabajo.idgrupo order by grupo';

             $importe = DB::select($query);

             return [
                 'tipos' => $tipos,
                 'importe' => $importe
             ];

         }
         catch (\Exception $e) {
             report($e);
             return response()->json([
                 'message' => $e->getMessage()
             ], 400);

         }
    }


}
