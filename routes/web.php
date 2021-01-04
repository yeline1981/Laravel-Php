<?php

    Route::group(['middleware'=>['web']],function(){
        Route::get('/','Auth\LoginController@showLoginForm');
        Route::post('/login', 'Auth\LoginController@login')->name('login');
    });

    Route::group(['middleware'=>['auth']],function(){

        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('/main', function () {
            return view('contenido/contenido');
        })->name('main');


        Route::group(['middleware' => ['Administrador', 'Vendedor', 'Diseñador']], function () {

            Route::get('/trabajos', 'Trabajos\TrabajoController@index');

            Route::post('/trabajos/store', 'Trabajos\TrabajoController@store');

            Route::post('/trabajos/update', 'Trabajos\TrabajoController@update');

            Route::put('/trabajos/{id}/check', 'Trabajos\TrabajoController@check');

            Route::put('/trabajos/{id}/display', 'Trabajos\TrabajoController@display');

            Route::put('/trabajos/{id}/correct', 'Trabajos\TrabajoController@correct');

            Route::put('/trabajos/{id}/done', 'Trabajos\TrabajoController@done');

            Route::put('/trabajos/{id}/deliver', 'Trabajos\TrabajoController@deliver');

            Route::put('/trabajos/{id}/drop', 'Trabajos\TrabajoController@destroy');

            Route::post('/trabajos/show', 'Trabajos\TrabajoVendedorController@show');

            Route::put('/trabajos/pay', 'Trabajos\TrabajoController@pay');

            Route::post('/trabajos/budget', 'Trabajos\TrabajoController@updateBudget');

            Route::put('/trabajos/bill', 'Trabajos\TrabajoController@bill');

            Route::put('/trabajos/{id}/cancel', 'Trabajos\TrabajoController@cancel');

            Route::get('/trabajos/imagen/list', 'Trabajos\TrabajoController@ListImagen');

            Route::post('/trabajos/imagen/store', 'Trabajos\TrabajoController@SaveImagen');

            Route::put('/trabajos/imagen/drop/{id}', 'Trabajos\TrabajoController@DeleteImagen');

            Route::get('/trabajos/vale', 'Trabajos\TrabajoController@imprimir');

            //---------------

            Route::get('/productos', 'Trabajos\TipoTrabajoController@index');

            Route::get('/productos/grupos/tipos', 'Trabajos\TipoTrabajoController@products');

            Route::get('/productos/grupos', 'Trabajos\TipoTrabajoController@groups');

            //---------------------

            Route::get('/usuarios/role', 'Usuarios\UsuarioControlador@role');

            Route::get('/papeles', 'Trabajos\PapelesController@index');

            Route::post('/papeles/store', 'Trabajos\PapelesController@store');

        });

        Route::group(['middleware' => ['Administrador', 'Vendedor']], function () {
            //rutas para caja

            Route::get('/caja/ventadiaria','Caja\CajaController@ventadiaria');

            Route::get('/caja/estados','Caja\CajaController@estados');

            Route::get('/caja/facturacion','Caja\CajaController@facturacion');

            Route::get('/caja/general','Caja\CajaController@index');


            //rutas para manejo de clientes

            Route::get('/clientes', 'Clientes\ClienteController@index');

            Route::post('/clientes/registrar', 'Clientes\ClienteController@create');

            Route::post('/clientes/actualizar', 'Clientes\ClienteController@update');

            Route::put('/clientes/eliminar', 'Clientes\ClienteController@destroy');

            Route::get('/clientes/exist', 'Clientes\ClienteController@search');


            //-----------------

            Route::get('/presupuestos', 'Trabajos\PresupuestoController@index');

            Route::post('/presupuestos/store', 'Trabajos\PresupuestoController@store');

            Route::post('/presupuestos/update', 'Trabajos\PresupuestoController@update');

            Route::post('/presupuestos/budget', 'Trabajos\PresupuestoController@budget');

            Route::post('/presupuestos/accept', 'Trabajos\PresupuestoController@toAccept');

            Route::put('/presupuestos/{id}/drop', 'Trabajos\PresupuestoController@destroy');

            Route::post('/presupuestos/imagen/store', 'Trabajos\PresupuestoController@SaveImagen');

            Route::put('/presupuestos/imagen/drop/{id}', 'Trabajos\PresupuestoController@DeleteImagen');

            Route::get('/presupuestos/imagen/list', 'Trabajos\PresupuestoController@ListImagen');

            Route::post('/presupuestos/tertiary', 'Trabajos\PresupuestoController@outSource');

            Route::post('/trabajos/tertiary', 'Trabajos\TrabajoController@outSource');

        });

        Route::group(['middleware' => ['Administrador']], function () {

            Route::get('/usuarios', 'Usuarios\UsuarioControlador@index');

            Route::post('/usuarios/registrar', 'Usuarios\UsuarioControlador@create');

            Route::put('/usuarios/actualizar', 'Usuarios\UsuarioControlador@update');

            Route::put('/usuarios/actualizar/password', 'Usuarios\UsuarioControlador@changePasswd');

            Route::put('/usuarios/eliminar', 'Usuarios\UsuarioControlador@destroy');


            //rutas para manejo de precios

            Route::get('/atributos', 'Precios\AtributoControlador@index');

            Route::put('/atributos/eliminar', 'Precios\AtributoControlador@destroy');

            Route::get('/reportes/general', 'Reportes\ReportesController@general');

            Route::get('/reportes/tendencia', 'Reportes\ReportesController@tendencia');

            //-------------------



        });

    });

