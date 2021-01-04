<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTrabajo extends Model
{
    protected $table= 'tipo_trabajo';

    //public $timestamps = false;

    protected $fillable = ['id','idgrupo', 'tipo'];

}
