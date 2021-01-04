<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';

    //public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['idtrabajo', 'data', 'name', 'created_at', 'updated_at'];

    public function trabajo()
    {
        return $this->belongsTo('App\Models\Presupuesto');
    }
}
