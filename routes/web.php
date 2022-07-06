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

    Route::get("/asientos", "AsientosController@index");
    Route::post("/asientos/store", "AsientosController@store");
    Route::put("/asientos/update", "AsientosController@update");
    Route::put("/asientos/deactivate", "AsientosController@deactivate");
    Route::put("/asientos/activate", "AsientosController@activate");
    Route::get("/asientos/listado", "AsientosController@listado");

    Route::get("/asociacion", "AsociacionController@index");
    Route::post("/asociacion/store", "AsociacionController@store");
    Route::put("/asociacion/update", "AsociacionController@update");
    Route::put("/asociacion/deactivate", "AsociacionController@deactivate");
    Route::put("/asociacion/activate", "AsociacionController@activate");
    Route::get("/asociacion/listado", "AsociacionController@listado");

    Route::get("/ciudades", "CiudadesController@index");
    Route::post("/ciudades/store", "CiudadesController@store");
    Route::put("/ciudades/update", "CiudadesController@update");
    Route::put("/ciudades/deactivate", "CiudadesController@deactivate");
    Route::put("/ciudades/activate", "CiudadesController@activate");
    Route::get("/ciudades/listado", "CiudadesController@listado");

    Route::get("/cobros", "CobrosController@index");
    Route::post("/cobros/store", "CobrosController@store");
    Route::put("/cobros/update", "CobrosController@update");
    Route::put("/cobros/deactivate", "CobrosController@deactivate");
    Route::put("/cobros/activate", "CobrosController@activate");
    Route::get("/cobros/listado", "CobrosController@listado");

    Route::get("/cobrosasientos", "CobrosasientosController@index");
    Route::post("/cobrosasientos/store", "CobrosasientosController@store");
    Route::put("/cobrosasientos/update", "CobrosasientosController@update");
    Route::put("/cobrosasientos/deactivate", "CobrosasientosController@deactivate");
    Route::put("/cobrosasientos/activate", "CobrosasientosController@activate");
    Route::get("/cobrosasientos/listado", "CobrosasientosController@listado");

    Route::get("/departamentos", "DepartamentosController@index");
    Route::post("/departamentos/store", "DepartamentosController@store");
    Route::put("/departamentos/update", "DepartamentosController@update");
    Route::put("/departamentos/deactivate", "DepartamentosController@deactivate");
    Route::put("/departamentos/activate", "DepartamentosController@activate");
    Route::get("/departamentos/listado", "DepartamentosController@listado");

    Route::get("/detallefacturas", "DetallefacturasController@index");
    Route::post("/detallefacturas/store", "DetallefacturasController@store");
    Route::put("/detallefacturas/update", "DetallefacturasController@update");
    Route::put("/detallefacturas/deactivate", "DetallefacturasController@deactivate");
    Route::put("/detallefacturas/activate", "DetallefacturasController@activate");
    Route::get("/detallefacturas/listado", "DetallefacturasController@listado");

    Route::get("/detallepedidos", "DetallepedidosController@index");
    Route::post("/detallepedidos/store", "DetallepedidosController@store");
    Route::put("/detallepedidos/update", "DetallepedidosController@update");
    Route::put("/detallepedidos/deactivate", "DetallepedidosController@deactivate");
    Route::put("/detallepedidos/activate", "DetallepedidosController@activate");
    Route::get("/detallepedidos/listado", "DetallepedidosController@listado");

    Route::get("/empresa", "EmpresaController@index");
    Route::post("/empresa/store", "EmpresaController@store");
    Route::put("/empresa/update", "EmpresaController@update");
    Route::put("/empresa/deactivate", "EmpresaController@deactivate");
    Route::put("/empresa/activate", "EmpresaController@activate");
    Route::get("/empresa/listado", "EmpresaController@listado");

    Route::get("/facturas", "FacturasController@index");
    Route::post("/facturas/store", "FacturasController@store");
    Route::put("/facturas/update", "FacturasController@update");
    Route::put("/facturas/deactivate", "FacturasController@deactivate");
    Route::put("/facturas/activate", "FacturasController@activate");
    Route::get("/facturas/listado", "FacturasController@listado");

    Route::get("/grupos", "GruposController@index");
    Route::post("/grupos/store", "GruposController@store");
    Route::put("/grupos/update", "GruposController@update");
    Route::put("/grupos/deactivate", "GruposController@deactivate");
    Route::put("/grupos/activate", "GruposController@activate");
    Route::get("/grupos/listado", "GruposController@listado");

    Route::get("/impuesto", "ImpuestoController@index");
    Route::post("/impuesto/store", "ImpuestoController@store");
    Route::put("/impuesto/update", "ImpuestoController@update");
    Route::put("/impuesto/deactivate", "ImpuestoController@deactivate");
    Route::put("/impuesto/activate", "ImpuestoController@activate");
    Route::get("/impuesto/listado", "ImpuestoController@listado");

    Route::get("/libromayor", "LibromayorController@index");
    Route::post("/libromayor/store", "LibromayorController@store");
    Route::put("/libromayor/update", "LibromayorController@update");
    Route::put("/libromayor/deactivate", "LibromayorController@deactivate");
    Route::put("/libromayor/activate", "LibromayorController@activate");
    Route::get("/libromayor/listado", "LibromayorController@listado");

    Route::get("/medida", "MedidaController@index");
    Route::post("/medida/store", "MedidaController@store");
    Route::put("/medida/update", "MedidaController@update");
    Route::put("/medida/deactivate", "MedidaController@deactivate");
    Route::put("/medida/activate", "MedidaController@activate");
    Route::get("/medida/listado", "MedidaController@listado");

    Route::get("/pagos", "PagosController@index");
    Route::post("/pagos/store", "PagosController@store");
    Route::put("/pagos/update", "PagosController@update");
    Route::put("/pagos/deactivate", "PagosController@deactivate");
    Route::put("/pagos/activate", "PagosController@activate");
    Route::get("/pagos/listado", "PagosController@listado");

    Route::get("/pagosasientos", "PagosasientosController@index");
    Route::post("/pagosasientos/store", "PagosasientosController@store");
    Route::put("/pagosasientos/update", "PagosasientosController@update");
    Route::put("/pagosasientos/deactivate", "PagosasientosController@deactivate");
    Route::put("/pagosasientos/activate", "PagosasientosController@activate");
    Route::get("/pagosasientos/listado", "PagosasientosController@listado");

    Route::get("/pedidos", "PedidosController@index");
    Route::post("/pedidos/store", "PedidosController@store");
    Route::put("/pedidos/update", "PedidosController@update");
    Route::put("/pedidos/deactivate", "PedidosController@deactivate");
    Route::put("/pedidos/activate", "PedidosController@activate");
    Route::get("/pedidos/listado", "PedidosController@listado");

    Route::get("/productos", "ProductosController@index");
    Route::post("/productos/store", "ProductosController@store");
    Route::put("/productos/update", "ProductosController@update");
    Route::put("/productos/deactivate", "ProductosController@deactivate");
    Route::put("/productos/activate", "ProductosController@activate");
    Route::get("/productos/listado", "ProductosController@listado");

    Route::get("/registros", "RegistrosController@index");
    Route::post("/registros/store", "RegistrosController@store");
    Route::put("/registros/update", "RegistrosController@update");
    Route::put("/registros/deactivate", "RegistrosController@deactivate");
    Route::put("/registros/activate", "RegistrosController@activate");
    Route::get("/registros/listado", "RegistrosController@listado");

    Route::get("/roles", "RolesController@index");
    Route::post("/roles/store", "RolesController@store");
    Route::put("/roles/update", "RolesController@update");
    Route::put("/roles/deactivate", "RolesController@deactivate");
    Route::put("/roles/activate", "RolesController@activate");
    Route::get("/roles/listado", "RolesController@listado");

    Route::get("/tipofactura", "TipofacturaController@index");
    Route::post("/tipofactura/store", "TipofacturaController@store");
    Route::put("/tipofactura/update", "TipofacturaController@update");
    Route::put("/tipofactura/deactivate", "TipofacturaController@deactivate");
    Route::put("/tipofactura/activate", "TipofacturaController@activate");
    Route::get("/tipofactura/listado", "TipofacturaController@listado");

    Route::get("/tipologia", "TipologiaController@index");
    Route::post("/tipologia/store", "TipologiaController@store");
    Route::put("/tipologia/update", "TipologiaController@update");
    Route::put("/tipologia/deactivate", "TipologiaController@deactivate");
    Route::put("/tipologia/activate", "TipologiaController@activate");
    Route::get("/tipologia/listado", "TipologiaController@listado");

    });


});
