<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrabajoDisenador extends Model
{
    protected $table = 'trabajos_disenador';

    protected $fillable = ['idtrabajo', 'idusuario', 'created_at'];

    public $timestamps = false;

    public function iddisenador()
    {
        return $this->belongsToMany('App\Usuario');
    }

    public function idtrabajo()
    {
        return $this->belongsToMany('App\Model\Trabajo');
    }
}
