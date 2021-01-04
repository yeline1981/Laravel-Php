<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table= 'usuarios';

    protected $guarded = ['role', 'password'];

    public $timestamps = false;

    protected $hidden = [
        'password', 'remember_token',
    ];

}
