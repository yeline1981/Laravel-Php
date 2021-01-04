<?php

namespace App\Http\Controllers\Trabajos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Trabajo;
use App\Models\Caja;
use App\Models\VistaTrabajos;
use App\Models\ImagenTrabajo;
use App\Models\TrabajoDisenador;
use App\Models\Estado;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;

class TrabajoController extends Controller
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
            $trabajos = VistaTrabajos::orderBy('id', 'desc')->paginate(11);
        }
        else{
            $val = explode("|", $request->criterio);

            $tipo = $val[1];
            $buscar = strtolower($request->buscar);
            $criterio = $val[0];

            if ($tipo == 'string'){
                $trabajos = VistaTrabajos::where( DB::raw('lower(view_trabajos.'.$criterio. ')'), 'like', '%'. $buscar . '%')
                ->orderBy('id', 'desc')->paginate(11);
            }
            else {
                $trabajos = VistaTrabajos::where( $criterio, 'like', '%'. $buscar . '%')
                ->orderBy('id', 'desc')->paginate(11);
            }
        }

        return [
            'pagination' => [
                'total'        => $trabajos->total(),
                'current_page' => $trabajos->currentPage(),
                'per_page'     => $trabajos->perPage(),
                'last_page'    => $trabajos->lastPage(),
                'from'         => $trabajos->firstItem(),
                'to'           => $trabajos->lastItem(),
            ],
            'trabajos' => $trabajos
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        if (Auth::check()) {

            $user = Auth::user()->id;

            try{

                $trabajo = new Trabajo();

                $trabajo->idtipotrabajo = $request->tipo;
                $trabajo->papel = $request->papel;
                $trabajo->formato = $request->formato;

                $trabajo->diseno = $request->diseno;
                $trabajo->contenido = $request->contenido;
                $trabajo->detalles = $request->detalles;

                $trabajo->idcliente = $request->idcliente;
                $trabajo->cantidad = $request->cantidad;
                $trabajo->precio = $request->precio;
                $trabajo->senado = $request->entrega;
                $trabajo->boleta = $request->boleta;

                //Log::info('Buscando atributo' );

                if ($request->get('frente') !== null){
                    $trabajo->frente = $request->frente;
                }

                if ($request->get('dorso') !== null){
                    $trabajo->dorso = $request->dorso;
                }

                if ($request->get('recubrimiento') !== null){
                    $trabajo->recubrimiento = $request->recubrimiento;
                }

                if ($request->get('terminacion') !== null){
                    $trabajo->terminacion = $request->terminacion;
                }

                if ($request->get('sangrado') !== null){
                    $trabajo->sangrado = $request->sangrado;
                }

                if ($request->get('encuadernado') !== null){
                    $trabajo->sangrado = $request->encuadernado;
                }

                $trabajo->save();

                return response()->json([
                    'trabajo' => $trabajo->id,
                    'message' => 'Success'
                ], 200);

            }
            catch (\Exception $e) {
                report($e);
                return response()->json([
                    'trabajo' => -1,
                    'message' => $e->getMessage()
                ], 400);
            }

        }
        else
        {
            return response()->json([
                'resp' => -5,
                'message' => 'Usuario no autenticado'
            ], 400);
        }
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
        if (!$request->ajax()) return redirect('/');

        try{

            $trabajo = Trabajo::findOrFail($request->id);

            //$trabajo->idtipo = $request->tipo;
            $trabajo->papel = $request->papel;
            $trabajo->formato = $request->formato;

            $trabajo->diseno = $request->diseno;
            $trabajo->contenido = $request->contenido;
            $trabajo->detalles = $request->detalles;

            $trabajo->cantidad = $request->cantidad;

            //$trabajo->precio = $request->precio;
            //$trabajo->senado = $request->senado;
            //$trabajo->factura = $request->factura;


            if ($request->get('frente') !== null){
                $trabajo->frente = $request->frente;
            }

            if ($request->get('dorso') !== null){
                $trabajo->dorso = $request->dorso;
            }

            if ($request->get('recubrimiento') !== null){
                $trabajo->recubrimiento = $request->recubrimiento;
            }

            if ($request->get('tapa') !== null){
                $trabajo->tapa = $request->tapa;
            }

            if ($request->get('sangrado') !== null){
                $trabajo->sangrado = $request->sangrado;
            }

            if ($request->get('encuadernado') !== null){
                $trabajo->encuadernado = $request->encuadernado;
            }

            if ($request->get('vias') !== null){
                $trabajo->vias = $request->vias;
            }

            if ($request->get('partes') !== null){
                $trabajo->partes = $request->partes;
            }

            $trabajo->save();

            //Asociar con vendedor

            return response()->json([
                'trabajo' => $trabajo,
                'message' => 'Success'
            ], 200);

        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'trabajo' => -1,
                'message' => $e->getMessage()
            ], 400);
        }

    }

    public function updateBudget(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{

            $trabajo = Trabajo::findOrFail($request->id);

            $trabajo->precio = $request->precio;
            $trabajo->iva = $request->iva;
            $trabajo->total = $request->total;

            $trabajo->save();

            return response()->json([
                'trabajo' => $trabajo->id,
                'message' => 'Success'
            ], 200);

        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'trabajo' => -1,
                'message' => $e->getMessage()
            ], 400);
        }

    }

    public function pay(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            $trabajo = Trabajo::findOrFail($request->id);

            $trabajo->senado = $trabajo->senado + $request->ingresado;

            $trabajo->save();

            $caja = new Caja();
            $caja->idtrabajo = $request->id;
            $caja->ingresa = $request->ingresado;
            $caja->save();

            return response()->json([
                'presupuesto' => $trabajo->id,
                'message' => 'Success'
            ], 200);

        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'presupuesto' => -1,
                'message' => $e->getMessage()
            ], 400);
        }

    }

    public function bill(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        if (Auth::check()) {
            try{
                $trabajo = Trabajo::findOrFail($request->id);

                $trabajo->factura = $request->factura;

                $trabajo->save();

                return response()->json([
                    'presupuesto' => $trabajo->id,
                    'message' => 'Success'
                ], 200);

            }
            catch (\Exception $e) {
                report($e);
                return response()->json([
                    'presupuesto' => -1,
                    'message' => $e->getMessage()
                ], 400);
            }
        }
        else
        {
            return response()->json([
                'resp' => -5,
                'message' => 'Usuario no autenticado'
            ], 400);
        }

    }

    public function destroy($id, Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $trabajo = Trabajo::findOrFail($id);
        $trabajo->delete();
    }

    public function check($id, Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{

            $trabajo = Trabajo::findOrFail($id);

            $estado = Estado::where('estado', '=', 'Aprobado')->first();
            $trabajo->idestado = $estado->id ;
            $trabajo->save();

            return response()->json([
                'trabajo' => $trabajo->id,
                'message' => 'Success'
            ], 200);
        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'trabajo' => -1,
                'message' => $e->getMessage()
            ], 400);
        }

    }

    public function done($id, Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{

            $trabajo = Trabajo::findOrFail($id);

            $estado = Estado::where('estado', '=', 'Listo')->first();
            $trabajo->idestado = $estado->id ;
            $trabajo->save();

            $user = Auth::user()->id;

            $vendedor = new TrabajoDisenador();
            $vendedor->idtrabajo = $trabajo->id;
            $vendedor->idusuario = $user;
            $vendedor->save();

            return response()->json([
                'trabajo' => $trabajo->id,
                'message' => 'Success'
            ], 200);
        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'trabajo' => -1,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function outSource(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $trabajo = Trabajo::findOrFail($request->id);
        $trabajo->terciar = true;
        $trabajo->save();

        return ['id' => $trabajo->id];
    }

    public function deliver($id, Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{

            $trabajo = Trabajo::findOrFail($id);

            $estado = Estado::where('estado', '=', 'Entregado')->first();
            $trabajo->idestado = $estado->id ;
            $trabajo->save();

            return response()->json([
                'trabajo' => $trabajo->id,
                'message' => 'Success'
            ], 200);
        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'trabajo' => -1,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function display($id, Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        if (Auth::check()) {
            try{

                $trabajo = Trabajo::findOrFail($id);
                $estado = Estado::where('estado', '=', 'Revisión Cliente')->first();
                $trabajo->idestado = $estado->id ;
                $trabajo->save();

                return response()->json([
                    'trabajo' => $trabajo->id,
                    'message' => 'Success'
                ], 200);
            }
            catch (\Exception $e) {
                report($e);
                return response()->json([
                    'trabajo' => -1,
                    'message' => $e->getMessage()
                ], 400);
            }
        }
        else
        {
            return response()->json([
                'resp' => -5,
                'message' => 'Usuario no autenticado'
            ], 400);
        }

    }

    public function correct($id, Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{

            $trabajo = Trabajo::findOrFail($id);

            $estado = Estado::where('estado', '=', 'Corregir Diseño')->first();

            $trabajo->idestado = $estado->id ;
            $trabajo->detalles = date("d/m/Y") . PHP_EOL . $request->comment . PHP_EOL . $trabajo->detalles;
            $trabajo->save();

            return response()->json([
                'trabajo' => $trabajo->id,
                'message' => 'Success'
            ], 200);
        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'trabajo' => -1,
                'message' => $e->getMessage()
            ], 400);
        }

    }

    public function cancel($id, Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try{

            $trabajo = Trabajo::findOrFail($id);
            $trabajo->idestado = 6 ;
            $trabajo->save();

            return response()->json([
                'trabajo' => $trabajo->id,
                'message' => 'Success'
            ], 200);
        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'trabajo' => -1,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function SaveImagen(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //try{
                $image = $request->get('imagen');       // your base64 encoded

                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                $base64 = explode(',', $image, strpos($image, ';'))[1];

                $img= Image::make($base64);

                $width  = $img->width();
                $height = $img->height();

                if ($width > 500 || $height > 500) {

                    $vertical   = (($width < $height) ? true : false);
                    $horizontal = (($width > $height) ? true : false);
                    $square     = (($width = $height) ? true : false);

                    if ($vertical) {
                        //$top = $bottom = 245;
                        $newHeight = 352;
                        $img->resize(null, $newHeight, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                    } else if ($horizontal) {
                        $newWidth = 480;
                        $img->resize($newWidth, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                    } else if ($square) {
                        $newWidth = 480;
                        $img->resize($newWidth, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }

                    $img->resizeCanvas(480, 352, 'center', false, '#ffffff');

                }

                $data = (string) $img->encode('data-url');

                $base64 = explode(',', $data, strpos($data, ';'))[1];


                $new = new ImagenTrabajo();
                $new->data = $base64 ;
                $new->name = $name;
                $new->idtrabajo = $request->id;
                $new->save();

                return response()->json([
                    'img' => $new->id,
                    'message' => 'Success'
                ], 200);
        /*
        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'img' => -1,
                'message' => $e->getMessage()
              ], 400);

        }
        */

    }

    public function DeleteImagen($id, Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $image = ImagenTrabajo::findOrFail($id);
        $image->delete();

    }

    public function ListImagen(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $imagenes = ImagenTrabajo::where('idtrabajo', '=', $request->id )->get();

        return response()->json([
            'imagenes' => $imagenes,
            'message' => 'Success'
        ], 200);
    }

    public function imprimir(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $nuevo = DB::table('trabajos')
                    ->join('clientes', 'clientes.id', '=', 'trabajos.idcliente')
                    ->join('tipo_trabajo', 'tipo_trabajo.id', '=', 'trabajos.idtipo')
                    ->join('grupos_tipos', 'grupos_tipos.id', '=', 'tipo_trabajo.idgrupo')
                    ->where('trabajos.id','=', $request->id )
                    ->select('clientes.nombre', 'clientes.telefono', 'clientes.direccion', 'trabajos.*',  'tipo_trabajo.tipo as tipo', 'grupos_tipos.friendly_name as grupo')
                    ->first();

        //return $nuevo;
        return view('vales.vale', compact('nuevo'));
    }



}
