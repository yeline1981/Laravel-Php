<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaFacturacion extends Model
{
    //
    protected $table = 'categoria_facturacion';

    protected $primaryKey = 'id';

    protected $fillable = ['categoria'];

}
