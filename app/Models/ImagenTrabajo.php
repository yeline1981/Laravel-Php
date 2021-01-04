<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenTrabajo extends Model
{
    protected $table = 'imagenes_trabajos';

    //public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['idtrabajo', 'data', 'name', 'created_at', 'updated_at'];

    public function trabajo()
    {
        return $this->belongsTo('App\Models\Trabajo');
    }
}
