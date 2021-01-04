<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrabajoVendedor extends Model
{
    protected $table = 'trabajo_vendedor';

    protected $fillable = ['idtrabajo', 'idvendedor', 'created_at'];

    public $timestamps = false;

    public function idvendedor()
    {
        return $this->belongsToMany('App\Usuario');
    }

    public function idtrabajo()
    {
        return $this->belongsToMany('App\Model\Trabajo');
    }
}
