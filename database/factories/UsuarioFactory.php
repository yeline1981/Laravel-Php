<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Usuario;
use App\Privilegio;
use Faker\Generator as Faker;


$factory->define(Usuario::class, function (Faker $faker) {

    return [
            'nombre' => 'Duilio Palacios',
            'login' => 'duilio',
            'password' => 'laravel',
            'idpriv' => 1
    ];
});
