<?php

namespace App\Http\Controllers\Trabajos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TipoTrabajo;
use App\Models\GruposTipo;
use DB;

class TipoTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        if (!$request->ajax()) return redirect('/');

        $tipos = DB::table('tipo_trabajo')
            ->join('grupos_tipos', 'tipo_trabajo.idgrupo', '=', 'grupos_tipos.id')
            ->select('tipo_trabajo.*', 'grupos_tipos.grupo', 'grupos_tipos.friendly_name')
            ->get();

        return['tipos' => $tipos] ;
    }

    public function products(Request $request){

        if (!$request->ajax()) return redirect('/');

        $productos = TipoTrabajo::where('idgrupo', '=' , $request->id)->get();

        return['productos' => $productos] ;
    }

    public function groups(Request $request){

        if (!$request->ajax()) return redirect('/');

        $grupos = GruposTipo::orderBy('id')->get();

        return['grupos' => $grupos] ;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
