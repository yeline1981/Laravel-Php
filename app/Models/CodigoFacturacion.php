<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoFacturacion extends Model
{
    //
    protected $table = 'codigos_facturacion';

    protected $primaryKey = 'id';

    protected $fillable = ['idcategoria', 'descripcion', 'updated_at'];


    public function categoria()
    {
        return $this->belongsTo('App\Models\CategoriaFacturacion');
    }



}
