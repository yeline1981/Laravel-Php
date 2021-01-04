<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrabajoFacturacion extends Model
{
    protected $table = 'trabajo_facturacion';

    protected $primaryKey = 'id';

    protected $fillable = ['idtrabajo', 'idcodigo', 'cantidad', 'created_at'];


    public function trabajo()
    {
        return $this->belongsTo('App\Models\Trabajo');
    }

    public function codigo()
    {
        return $this->belongsTo('App\Models\CodigoFacturacion');
    }
}
