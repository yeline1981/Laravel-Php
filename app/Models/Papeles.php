<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Papeles extends Model
{
    protected $table = 'papeles';

    protected $primaryKey = 'id';

    protected $fillable = ['papel'];

}
