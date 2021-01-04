<?php

namespace App\Http\Controllers\Caja;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrabajoFacturacion;
use DB;

class FacturacionController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $codigos = DB::table('codigos_facturacion')
                     ->orderBy('descripcion', 'asc')
                     ->get();

        return [
            'codigos' => $codigos
        ];
    }

    public function create(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{

            $trabajo = new TrabajoFacturacion();
            $trabajo->idtrabajo = $request->idtrabajo;
            $trabajo->idcodigo = $request->idcodigo;
            $trabajo->cantidad = $request->cantidad;

            $trabajo->save();

            return response()->json([
                'trabajo' => $trabajo->id,
                'message' => 'Success'
              ], 200);
        }
        catch (\Exception $e) {

            if ($e->getCode() == 23505) {
                // Deal with duplicate key error
                return response()->json([
                'trabajo' => -2
              ], 400);
            }

            report($e);
            return response()->json([
                'trabajo' => -1,
                'message' => $e->getMessage()
              ], 400);
        }

    }


}
