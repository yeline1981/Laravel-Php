<?php

namespace App\Http\Controllers\Trabajos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TrabajoVendedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TrabajoVendedorController extends Controller
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


    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        if (Auth::check()) {

            $user = Auth::user()->id;

            $relacion = new TrabajoVendedor();
            $relacion->id = $request->idtrabajo;
            $relacion->idvendedor = $user;
            $relacion->save();

            return response()->json([
                'message' => 'Success'
            ], 200);

        }
        else
        {
            return response()->json([
                'message' => 'Usuario no autenticado'
            ], 400);
        }
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
