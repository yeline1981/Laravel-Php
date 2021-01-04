<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cliente;
use DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        if ($request->buscar == ''){
            $clientes = Cliente::select('clientes.id', 'clientes.nombre', 'clientes.direccion', 'clientes.email', 'clientes.telefono', 'clientes.created_at')
            ->orderBy('clientes.created_at', 'desc')->paginate(11);
        }
        else{
            $val = explode("|", $request->criterio);

            $tipo = $val[1];
            $buscar = strtolower($request->buscar);
            $criterio = $val[0];

            if ($tipo == 'string'){
                $clientes = Cliente::select('clientes.id', 'clientes.nombre', 'clientes.direccion', 'clientes.email', 'clientes.telefono', 'clientes.created_at')
                ->where(DB::raw('lower(clientes.'.$criterio. ')'), 'like', '%'. $buscar . '%')
                ->orderBy('clientes.created_at', 'desc')->paginate(11);
            }
            else {
                $clientes = Cliente::select('clientes.id', 'clientes.nombre', 'clientes.direccion', 'clientes.email', 'clientes.telefono', 'clientes.created_at')
                ->where('clientes.'.$criterio, 'like', '%'. $buscar . '%')
                ->orderBy('clientes.created_at', 'desc')->paginate(11);
            }
        }

        return [
            'pagination' => [
                'total'        => $clientes->total(),
                'current_page' => $clientes->currentPage(),
                'per_page'     => $clientes->perPage(),
                'last_page'    => $clientes->lastPage(),
                'from'         => $clientes->firstItem(),
                'to'           => $clientes->lastItem(),
            ],
            'clientes' => $clientes
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{

            $cliente = new Cliente();
            $cliente->id = $request->ident;
            $cliente->nombre = $request->nombre;

            $cliente->direccion = $request->direccion;

            $cliente->email = $request->email;
            $cliente->telefono = $request->telefono;

            $cliente->save();

            return response()->json([
                'cliente' => $cliente->id,
                'message' => 'Success'
              ], 200);
        }
        catch (\Exception $e) {

            if ($e->getCode() == 23505) {
                // Deal with duplicate key error
                return response()->json([
                'cliente' => -2
              ], 400);
            }

            report($e);
            return response()->json([
                'cliente' => -1,
                'message' => $e->getMessage()
              ], 400);
        }

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       //
       if (!$request->ajax()) return redirect('/');

       try{

           $cliente = Cliente::findOrFail($request->id);

           $cliente->direccion = $request->direccion;
           $cliente->email = $request->email;
           $cliente->telefono = $request->telefono;

           $cliente->save();

           return response()->json([
               'cliente' => $cliente->id,
               'message' => 'Success'
             ], 200);

           }
           catch (\Exception $e) {
               report($e);
               return response()->json([
                   'cliente' => -1,
                   'message' => $e->getMessage()
                 ], 400);

           }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if (!$request->ajax()) return redirect('/');

        try{
            //$cant = DB::select('delete from clientes where id = ?', array($request->id));

            $clientes = Cliente::findOrFail($request->id);
            $clientes->delete();

            return response()->json([
                'cliente' => 0,
                'message' => 'Success'
              ], 200);

        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'cliente' => -1,
                'message' => $e->getMessage()
              ], 400);

        }
    }

    public function search(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            $cliente = Cliente::findOrFail($request->id);

            return ['cliente' => $cliente];
        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'cliente' => -2,
                'message' => $e->getMessage()
              ], 400);

        }

    }

    public function selectCliente(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $clientes = Cliente::where('id', 'like', '%'. $filtro . '%')
            ->orWhere(DB::raw('lower(nombre)'), 'like', '%'. $filtro . '%')
            ->select('id','nombre','saldo')
            ->orderBy('nombre', 'asc')->get();

        return ['clientes' => $clientes];
    }
}
