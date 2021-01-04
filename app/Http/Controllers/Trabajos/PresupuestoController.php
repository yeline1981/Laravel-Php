<?php

namespace App\Http\Controllers\Trabajos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Presupuesto;
use App\Models\Trabajo;
use App\Models\TrabajoVendedor;
use App\Models\TrabajoFacturacion;
use App\Models\VistaSolicitudes;
use App\Models\Imagen;
use App\Models\ImagenTrabajo;
use Illuminate\Support\Facades\Auth;
use Image;
use DB;


class PresupuestoController extends Controller
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
            $trabajos = VistaSolicitudes::paginate(11);
        }
        else{
            $val = explode("|", $request->criterio);

            $tipo = $val[1];
            $buscar = strtolower($request->buscar);
            $criterio = $val[0];

            if ($tipo == 'string'){
                $trabajos = VistaSolicitudes::where(DB::raw('lower(trabajos.'.$criterio. ')'), 'like', '%'. $buscar . '%')
                ->sortByDesc('created_at')->paginate(11);
            }
            else {
                $trabajos = VistaSolicitudes::where('trabajos.'.$criterio, 'like', '%'. $buscar . '%')
                ->sortByDesc('created_at')->paginate(11);
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

            //$user = Auth::user()->id;

            try{

                $trabajo = new Presupuesto();

                $trabajo->idtipo = $request->idtipotrabajo;
                $trabajo->papel = $request->papel;
                $trabajo->formato = $request->formato;

                $trabajo->diseno = $request->diseno;
                $trabajo->contenido = $request->contenido;
                $trabajo->detalles = $request->detalles;

                $trabajo->cantidad = $request->cantidad;

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

                if ($request->get('unidad') !== null){
                    $trabajo->unidad = $request->unidad;
                }

                if ($request->get('numerado') !== null){
                    $trabajo->numerado = $request->numerado;
                }

                if ($request->get('desde') !== null){
                    $trabajo->desde = $request->desde;
                }

                if ($request->get('hasta') !== null){
                    $trabajo->hasta = $request->hasta;
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
            $trabajo = Presupuesto::findOrFail($request->id);

            $trabajo->papel = $request->papel;
            $trabajo->formato = $request->formato;

            $trabajo->diseno = $request->diseno;
            $trabajo->contenido = $request->contenido;
            $trabajo->detalles = $request->detalles;

            $trabajo->cantidad = $request->cantidad;

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

    public function budget(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            $trabajo = Presupuesto::findOrFail($request->id);

            $trabajo->precio = $request->precio;
            $trabajo->iva = $request->iva;
            $trabajo->total = $request->total;

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

    public function toAccept(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        if (Auth::check()) {


            try{

                $trabajo = Presupuesto::findOrFail($request->id);

                $nuevo = Trabajo::firstOrNew($trabajo->toArray());
                $nuevo->idcliente = $request->idcliente;
                $nuevo->save();


                $imagenes = Imagen::where('idtrabajo', '=',$trabajo->id)->get();

                foreach ($imagenes as $imagen) {
                    $copia = new ImagenTrabajo();
                    $copia->idtrabajo = $nuevo->id;
                    $copia->name = $imagen->name;
                    $copia->data = $imagen->data;
                    $copia->save();
                }

                $user = Auth::user()->id;

                $vendedor = new TrabajoVendedor();
                $vendedor->idtrabajo = $nuevo->id;
                $vendedor->idvendedor = $user;
                $vendedor->save();

                $trabajo->delete();

                return response()->json([
                    'presupuesto' => $nuevo->id,
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


    public function outSource(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $trabajo = Presupuesto::findOrFail($request->id);
        $trabajo->terciar = true;
        $trabajo->save();

        return ['id' => $trabajo->id];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $trabajo = Presupuesto::findOrFail($id);
        $trabajo->delete();
    }


    public function SaveImagen(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
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

                $new = new Imagen();
                $new->data = $base64 ;
                $new->name = $name;
                $new->idtrabajo = $request->id;
                $new->save();

                return response()->json([
                    'img' => $new->id,
                    'message' => 'Success'
                ], 200);
        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'img' => -1,
                'message' => $e->getMessage()
              ], 400);

        }
    }

    public function DeleteImagen($id, Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $image = Imagen::findOrFail($id);
        $image->delete();

    }

    public function ListImagen(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $imagenes = Imagen::where('idtrabajo', '=', $request->id )->get();

        return response()->json([
            'imagenes' => $imagenes,
            'message' => 'Success'
        ], 200);
    }

}
