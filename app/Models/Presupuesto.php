<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $table = 'presupuestar';

    protected $fillable = ['precio', 'iva', 'total', 'terciar',
                           'idtipo', 'cantidad', 'unidad',
                           'desde', 'hasta', 'numerado',
                           'detalles', 'diseno', 'papel', 'formato', 'frente', 'dorso',
                           'contenido', 'recubrimiento', 'terminacion', 'sangrado','tapa',
                           'encuadernado', 'vias', 'partes',
                           'created_at', 'updated_at'];

    //public $timestamps = false;

    public function tipotrabajo()
    {
        return $this->belongsTo('App\Models\TipoTrabajo');
    }

    public function papeles()
    {
        return $this->belongsTo('App\Models\Papeles');
    }
}
