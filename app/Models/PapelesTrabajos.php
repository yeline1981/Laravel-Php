<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PapelesTrabajos extends Model
{
    //
    protected $table = 'papeles_trabajos';

    protected $primaryKey = 'id';

    protected $fillable = ['idpapel', 'idtipo', 'updated_at'];


    public function papel()
    {
        return $this->belongsTo('App\Models\Papeles');
    }

    public function tipo()
    {
        return $this->belongsTo('App\Models\TipoTrabajo');
    }
}
