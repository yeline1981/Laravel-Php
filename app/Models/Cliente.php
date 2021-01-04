<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table= 'clientes';

    //public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['nombre','direccion', 'email', 'telefono', 'created_at', 'updated_at'];

}
