<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    protected $table = 'trabajos';

    protected $primaryKey = 'id';

    protected $fillable = ['precio',  'iva', 'total', 'senado', 'factura', 'terciar',
                            'idtipo', 'cantidad', 'unidad',
                            'desde', 'hasta', 'numerado',
                            'detalles', 'diseno', 'papel', 'formato', 'frente', 'dorso',
                            'contenido', 'recubrimiento', 'terminacion', 'sangrado', 'tapa',
                            'encuadernado', 'vias', 'partes',
                            'idestado',
                            'created_at', 'updated_at'];

    public function tipotrabajo()
    {
        return $this->belongsTo('App\Models\TipoTrabajo');
    }

    public function papeles()
    {
        return $this->belongsTo('App\Models\Papeles');
    }
}
