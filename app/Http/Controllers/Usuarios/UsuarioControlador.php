<?php

namespace App\Http\Controllers\Usuarios;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Usuario;

class UsuarioControlador extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $usuarios = Usuario::where('role', '<>', 'System')
                        ->orderBy('id', 'desc')
                        ->paginate(10);
        }
        else{
            $usuarios = Usuario::where([
                [$criterio, 'like', '%'. $buscar . '%'],
                ['role', '<>', 'System'],
            ])
            ->orderBy('id', 'asc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'        => $usuarios->total(),
                'current_page' => $usuarios->currentPage(),
                'per_page'     => $usuarios->perPage(),
                'last_page'    => $usuarios->lastPage(),
                'from'         => $usuarios->firstItem(),
                'to'           => $usuarios->lastItem(),
            ],
            'usuarios' => $usuarios
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
            $usuario = new Usuario();
            $usuario->nombre = $request->nombre;
            $usuario->login = $request->login;
            $usuario->role = $request->role;
            $usuario->password = bcrypt( $request->password);

            $usuario->save();

            return response()->json([
                'user' => $usuario->id,
                'message' => 'Success'
              ], 200);
        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'user' => -1,
                'message' => $e->getMessage()
              ], 400);

        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        try{
            $usuario = Usuario::findOrFail($request->id);

            $usuario->role = $request->role;
            $usuario->save();

            return response()->json([
                'user' => $usuario->id ,
                'message' => 'Success'
            ], 200);

        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'user' => -1,
                'message' => $e->getMessage()
            ], 400);

        }
    }

    public function changePasswd(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        try{
            $usuario = Usuario::findOrFail($request->id);

            $usuario->password = bcrypt( $request->newpassword);
            $usuario->save();

            return response()->json([
                'user' => $usuario->id ,
                'message' => 'Success'
            ], 200);

        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'user' => -1,
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

        $usuarios = Usuario::findOrFail($request->id);
        $usuarios->delete();


    }

    public function role(Request $request)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            return response()->json(['role' => $role]);
        }
        else{
            return response()->json(['role' => 'none']);
        }

    }
}
