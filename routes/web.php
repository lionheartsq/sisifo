<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', 'Auth\LoginController@showLoginForm');
//Auth::routes(['register'=>false,'reset'=>false]);

//accesos para los usuarios que no estan autenticados
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/', 'Auth\LoginController@login')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
});
//---------------------------------------------------------------------------//

//accesos para los usuarios que si estan autenticados
    Route::group(['middleware' => ['auth']], function () {

        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
        Route::post('/pass', 'Auth\LoginController@pass')->name('pass');

        Route::get('/principal', function () {
            return view('contenido/contenido');
        })->name('principal');

        Route::get('/pruebas', function () {
            return view('home');
        })->name('pruebas');
//---------------------------------------------------------------------------//

Route::group(['middleware' => ['Superadministrador']], function () {

    Route::get("/clientes", "ClientesController@index");
    Route::post("/clientes/store", "ClientesController@store");
    Route::put("/clientes/update", "ClientesController@update");
    Route::put("/clientes/deactivate", "ClientesController@deactivate");
    Route::put("/clientes/activate", "ClientesController@activate");
    Route::get("/clientes/listado", "ClientesController@listado");

    Route::get("/proveedores", "ProveedoresController@index");
    Route::post("/proveedores/store", "ProveedoresController@store");
    Route::put("/proveedores/update", "ProveedoresController@update");
    Route::put("/proveedores/deactivate", "ProveedoresController@deactivate");
    Route::put("/proveedores/activate", "ProveedoresController@activate");
    Route::get("/proveedores/listado", "ProveedoresController@listado");

    Route::get("/usuarios", "UsuariosController@index");
    Route::post("/usuarios/store", "UsuariosController@store");
    Route::put("/usuarios/update", "UsuariosController@update");
    Route::put("/usuarios/deactivate", "UsuariosController@deactivate");
    Route::put("/usuarios/activate", "UsuariosController@activate");
    Route::get("/usuarios/listado", "UsuariosController@listado");

    });


});
