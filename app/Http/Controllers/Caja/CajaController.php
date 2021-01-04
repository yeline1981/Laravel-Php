<?php

namespace App\Http\Controllers\Caja;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Caja;
use App\Models\Trabajo;
use DB;

class CajaController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        if ($request->filled('filter')) {

            $caja = Caja::join('trabajos', 'trabajos.id', '=', 'caja.idtrabajo')
                    ->join('clientes', 'clientes.id' , '=', 'trabajos.idcliente')
                    ->join('tipo_trabajo', 'tipo_trabajo.id', '=', 'trabajos.idtipo')
                    ->select('idtrabajo', 'clientes.nombre as cliente', 'tipo_trabajo.tipo as producto', 'caja.ingresa', DB::raw('to_char(caja.updated_at, \'dd-mm-yyyy\') as pago'))
                    ->orderBy('caja.updated_at', 'desc')
                    ->paginate(10);
        }
        else{
            $filtros = [];

            if ($request->filled('cliente')) {
                array_push($filtros, [DB::raw('lower(clientes.nombre)') , 'like', '%'. strtolower($request->cliente) . '%']);
            }

            if ($request->filled('idtrabajo')) {
                array_push($filtros, ['caja.idtrabajo' , '=', $request->idtrabajo]);
            }

            if ($request->filled('pago')) {
                array_push($filtros, [DB::raw('to_char(caja.updated_at, \'dd-mm-yyyy\')') , '=', $request->pago]);
            }

            if ($request->filled('producto')) {
                array_push($filtros, [DB::raw('lower(tipo_trabajo.tipo)') , 'like', '%'. strtolower($request->tipotrabajo) . '%']);
            }


            $caja = Caja::join('trabajos', 'trabajos.id', '=', 'caja.idtrabajo')
                    ->join('clientes', 'clientes.id' , '=', 'trabajos.idcliente')
                    ->join('tipo_trabajo', 'tipo_trabajo.id', '=', 'trabajos.idtipo')
                    ->where($filtros)
                    ->select('idtrabajo', 'clientes.nombre as cliente', 'tipo_trabajo.tipo as producto', 'caja.ingresa', DB::raw('to_char(caja.updated_at, \'dd-mm-yyyy\') as pago'))
                    ->orderBy('caja.updated_at', 'desc')
                    ->paginate(10);
        }

        return ['pagination' => [
                    'total'        => $caja->total(),
                    'current_page' => $caja->currentPage(),
                    'per_page'     => $caja->perPage(),
                    'last_page'    => $caja->lastPage(),
                    'from'         => $caja->firstItem(),
                    'to'           => $caja->lastItem(),
                ],
                'caja' => $caja];

    }

    public function ventadiaria(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $caja = DB::select('select clientes.nombre as cliente, tipo_trabajo.tipo, gr.*, trabajos.factura
                                from clientes, tipo_trabajo, trabajos, (select idtrabajo, sum(ingresa) as total
                                                    from caja
                                                    where date(to_char(caja.updated_at, \'dd-mm-yyyy\')) = current_date
                                                    group by idtrabajo) gr
                            where gr.idtrabajo = trabajos.id and tipo_trabajo.id = trabajos.idtipo and trabajos.idcliente = clientes.id');

        return ['caja' => $caja];

    }

    public function imprimir(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $venta = Caja::where('id','=',$request->id) ->first();

        return view('vales.vale', compact('venta'));
    }

    public function facturacion(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        if ($request->filled('filter')) {

            $trabajos = Trabajo::join('tipo_trabajo', 'trabajos.idtipo', '=', 'tipo_trabajo.id')
                            ->join('clientes', 'trabajos.idcliente', '=', 'clientes.id')
                            ->select('tipo_trabajo.tipo as tipotrabajo', 'clientes.nombre as cliente', 'trabajos.id', 'trabajos.total', 'trabajos.iva', 'trabajos.precio', 'trabajos.senado', 'trabajos.factura', DB::raw('to_char(trabajos.created_at, \'dd-mm-yyyy\') as fecha') )
                            ->orderBy('trabajos.id', 'desc')
                            ->paginate(10);
        }
        else{
            $filtros = [];

            if ($request->filled('cliente')) {
                array_push($filtros, [DB::raw('lower(clientes.nombre)') , 'like', '%'. strtolower($request->cliente) . '%']);
            }

            if ($request->filled('fecha')) {
                array_push($filtros, [DB::raw('to_char(trabajos.created_at, \'dd-mm-yyyy\')') , '=', $request->fecha]);
            }

            if ($request->filled('tipotrabajo')) {
                array_push($filtros, [DB::raw('lower(tipo_trabajo.tipo)') , 'like', '%'. strtolower($request->tipotrabajo) . '%']);
            }


            $trabajos = Trabajo::join('tipo_trabajo', 'trabajos.idtipo', '=', 'tipo_trabajo.id')
                ->join('clientes', 'trabajos.idcliente', '=', 'clientes.id')
                ->where($filtros)
                ->select('tipo_trabajo.tipo as tipotrabajo', 'clientes.nombre as cliente', 'trabajos.id', 'trabajos.total', 'trabajos.iva', 'trabajos.precio', 'trabajos.senado', 'trabajos.factura', DB::raw('to_char(trabajos.created_at, \'dd-mm-yyyy\') as fecha'))
                ->orderBy('trabajos.id', 'desc')
                ->paginate(10);
        }

        return ['pagination' => [
                        'total'        => $trabajos->total(),
                        'current_page' => $trabajos->currentPage(),
                        'per_page'     => $trabajos->perPage(),
                        'last_page'    => $trabajos->lastPage(),
                        'from'         => $trabajos->firstItem(),
                        'to'           => $trabajos->lastItem(),
                    ],
                'trabajos' => $trabajos];
    }

    public function estados(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $subquery = DB::table('trabajos')
                    ->select('idcliente', DB::raw('count(*) as cant, sum(total) as importe, COALESCE(sum(senado), 0) as senado'))
                    ->where('idestado', '<>', 6)
                    ->groupBy('idcliente');


        $deudas = DB::table('clientes')
                    ->joinSub($subquery, 'subquery', function ($join){
                        $join->on('clientes.id', '=', 'subquery.idcliente');
                    })
                    ->select('nombre', DB::raw('(importe-senado) as deuda, subquery.*'))
                    ->where( DB::raw('importe-senado'), '>' , 0)
                    ->paginate(10);

        return ['pagination' => [
                        'total'        => $deudas->total(),
                        'current_page' => $deudas->currentPage(),
                        'per_page'     => $deudas->perPage(),
                        'last_page'    => $deudas->lastPage(),
                        'from'         => $deudas->firstItem(),
                        'to'           => $deudas->lastItem(),
                    ],
                'deudas' => $deudas];
    }


}
