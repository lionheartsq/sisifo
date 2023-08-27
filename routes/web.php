<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Redis;
use App\Jobs\Prueba;
use App\Tb_inventario;
use App\Tb_nomina;
use App\Tb_detalle_inventario;
use App\Exports\DetalleNominaFija;
use App\Exports\DetalleNominaDestajo;
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
    Route::get("/clientes/listadofiltrado/{cedula}", "ClientesController@listadoFiltrado");

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
    Route::post("/empresa/update", "EmpresaController@update");
    Route::put("/empresa/deactivate", "EmpresaController@deactivate");
    Route::put("/empresa/activate", "EmpresaController@activate");
    Route::get("/empresa/listado", "EmpresaController@listado");

    Route::get("/facturas", "FacturasController@index");
    Route::post("/facturas/store", "FacturasController@store");
    Route::put("/facturas/update", "FacturasController@update");
    Route::put("/facturas/deactivate", "FacturasController@deactivate");
    Route::put("/facturas/activate", "FacturasController@activate");
    Route::get("/facturas/listado", "FacturasController@listado");
    Route::get("/facturas/ultimo", "FacturasController@ultimo");

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

    Route::get("/empleados", "EmpleadosController@index");
    Route::post("/empleados/store", "EmpleadosController@store");
    Route::put("/empleados/update", "EmpleadosController@update");
    Route::put("/empleados/deactivate", "EmpleadosController@deactivate");
    Route::put("/empleados/activate", "EmpleadosController@activate");
    Route::get("/empleados/listado", "EmpleadosController@listado");
    Route::get("/empleados/selectEmpleados", "EmpleadosController@selectEmpleados");

    Route::get("/control", "ControlController@index");
    Route::post("/control/store", "ControlController@store");
    Route::put("/control/update", "ControlController@update");
    Route::put("/control/deactivate", "ControlController@deactivate");
    Route::put("/control/activate", "ControlController@activate");
    Route::get("/control/listado", "ControlController@listado");
    Route::get("/control/selectNombresApellidos/{documento}", "ControlController@selectNombresApellidos");
    Route::get("/control/selectcontrol", "ControlController@selectControl");

    Route::get("/historico", "HistoricoController@index");
    Route::get("/historico/listarfecha", "HistoricoController@listarfecha");
    Route::post("/historico/store", "HistoricoController@store");
    Route::post("/historico/store2", "HistoricoController@store2");
    Route::put("/historico/update", "HistoricoController@update");
    Route::put("/historico/deactivate", "HistoricoController@deactivate");
    Route::put("/historico/activate", "HistoricoController@activate");
    Route::get("/historico/listado", "HistoricoController@listado");
    Route::get("/historico/selectNombresApellidos/{documento}", "HistoricoController@selectNombresApellidos");
    Route::get("/historico/selecthistorico", "HistoricoController@selectHistorico");
    Route::get("/historico/mostrartHistorico", "HistoricoController@mostrarHistorico");
    Route::get("/historico/mostrarIngresos", "HistoricoController@mostrarIngresos");
    Route::get("/historico/mostrartSalidas", "HistoricoController@mostrarSalidas");






    Route::get("/financiera", "Tb_informacion_financieraController@index");
    Route::post("/financiera/store", "Tb_informacion_financieraController@store");
    Route::put("/financiera/update", "Tb_informacion_financieraController@update");
    Route::put("/financiera/deactivate", "Tb_informacion_financieraController@deactivate");
    Route::put("/financiera/activate", "Tb_informacion_financieraController@activate");
    Route::post("/financiera/actualizar", "Tb_informacion_financieraController@actualizar");

    Route::get("/area", "Tb_areaController@index");
    Route::post("/area/store", "Tb_areaController@store");
    Route::put("/area/update", "Tb_areaController@update");
    Route::put("/area/deactivate", "Tb_areaController@deactivate");
    Route::put("/area/activate", "Tb_areaController@activate");
    Route::get("/area/selectArea", "Tb_areaController@selectArea");
    Route::get("/area/selectthisArea", "Tb_areaController@selectthisArea");

    Route::get("/proceso", "Tb_procesoController@index");
    Route::post("/proceso/store", "Tb_procesoController@store");
    Route::put("/proceso/update", "Tb_procesoController@update");
    Route::put("/proceso/deactivate", "Tb_procesoController@deactivate");
    Route::put("/proceso/activate", "Tb_procesoController@activate");
    Route::get("/proceso/selectProceso", "Tb_procesoController@selectProceso");

    Route::get("/perfil", "Tb_perfilController@index");
    Route::post("/perfil/store", "Tb_perfilController@store");
    Route::put("/perfil/update", "Tb_perfilController@update");
    Route::put("/perfil/deactivate", "Tb_perfilController@deactivate");
    Route::put("/perfil/activate", "Tb_perfilController@activate");
    Route::get("/perfil/selectPerfil", "Tb_perfilController@selectPerfil");
    Route::get("/perfil/selectRelacion/{id}", "Tb_perfilController@selectRelacion");

    Route::get("/unidad", "Tb_unidad_baseController@index");
    Route::post("/unidad/store", "Tb_unidad_baseController@store");
    Route::put("/unidad/update", "Tb_unidad_baseController@update");
    Route::put("/unidad/deactivate", "Tb_unidad_baseController@deactivate");
    Route::put("/unidad/activate", "Tb_unidad_baseController@activate");
    Route::get("/unidad/selectUnidad", "Tb_unidad_baseController@selectUnidad");

    Route::get("/materia", "Tb_tipo_materiaController@index");
    Route::post("/materia/store", "Tb_tipo_materiaController@store");
    Route::put("/materia/update", "Tb_tipo_materiaController@update");
    Route::put("/materia/deactivate", "Tb_tipo_materiaController@deactivate");
    Route::put("/materia/activate", "Tb_tipo_materiaController@activate");
    Route::get("/materia/selectUnidad", "Tb_tipo_materiaController@selectMateria");

    Route::get("/gestionmateria", "Tb_gestion_materia_primaController@index");
    Route::post("/gestionmateria/store", "Tb_gestion_materia_primaController@store");
    Route::put("/gestionmateria/update", "Tb_gestion_materia_primaController@update");
    Route::put("/gestionmateria/deactivate", "Tb_gestion_materia_primaController@deactivate");
    Route::put("/gestionmateria/activate", "Tb_gestion_materia_primaController@activate");
    Route::get("/gestionmateria/selectTipoMateria", "Tb_gestion_materia_primaController@selectTipoMateria");
    Route::get("/gestionmateria/selectUnidadBase", "Tb_gestion_materia_primaController@selectUnidadBase");
    Route::get("/gestionmateria/selectGestionMateria", "Tb_gestion_materia_primaController@selectGestionMateria");

    Route::get("/coleccion", "Tb_coleccionController@index");
    Route::post("/coleccion/store", "Tb_coleccionController@store");
    Route::put("/coleccion/update", "Tb_coleccionController@update");
    Route::put("/coleccion/deactivate", "Tb_coleccionController@deactivate");
    Route::put("/coleccion/activate", "Tb_coleccionController@activate");
    Route::get("/coleccion/selectColeccion", "Tb_coleccionController@selectColeccion");

    Route::get("/manodeobraproducto", "Tb_mano_de_obra_productoController@index");
    Route::post("/manodeobraproducto/store", "Tb_mano_de_obra_productoController@store");
    Route::put("/manodeobraproducto/update", "Tb_mano_de_obra_productoController@update");
    Route::put("/manodeobraproducto/deactivate", "Tb_mano_de_obra_productoController@deactivate");
    Route::get("/manodeobraproducto/selectRelacionPerfil/{id}", "Tb_mano_de_obra_productoController@selectRelacionPerfil");
    Route::get("/manodeobraproducto/valorMinuto/{id}", "Tb_mano_de_obra_productoController@valorMinuto");

    Route::get("/materiaprimaproducto", "Tb_materia_prima_productoController@index");
    Route::post("/materiaprimaproducto/store", "Tb_materia_prima_productoController@store");
    Route::put("/materiaprimaproducto/update", "Tb_materia_prima_productoController@update");
    Route::put("/materiaprimaproducto/deactivate", "Tb_materia_prima_productoController@deactivate");
    Route::get("/materiaprimaproducto/selectMateriaPrimaProducto", "Tb_materia_prima_productoController@selectMateriaPrimaProducto");
    Route::get("/materiaprimaproducto/selectGestionMateria", "Tb_materia_prima_productoController@selectGestionMateria");
    Route::get("/materiaprimaproducto/valorPrecioBase/{id}", "Tb_materia_prima_productoController@valorPrecioBase");

    Route::get("/concepto", "Tb_concepto_cifController@index");
    Route::post("/concepto/store", "Tb_concepto_cifController@store");
    Route::put("/concepto/update", "Tb_concepto_cifController@update");
    Route::put("/concepto/deactivate", "Tb_concepto_cifController@deactivate");
    Route::put("/concepto/activate", "Tb_concepto_cifController@activate");
    Route::get("/concepto/selectConcepto", "Tb_concepto_cifController@selectConcepto");

    Route::get("/maquinaria", "Tb_maquinariaController@index");
    Route::post("/maquinaria/store", "Tb_maquinariaController@store");
    Route::put("/maquinaria/update", "Tb_maquinariaController@update");
    Route::put("/maquinaria/deactivate", "Tb_maquinariaController@deactivate");
    Route::put("/maquinaria/activate", "Tb_maquinariaController@activate");
    Route::get("/maquinaria/selectMaquinaria", "Tb_maquinariaController@selectMaquinaria");

    Route::get("/hojadecosto/total/{identificador}", "Hoja_De_CostosController@acumuladoTotal");
    Route::get("/hojadecosto/depreciacion/{identificador}", "Hoja_De_CostosController@maquinariaTotal");
    Route::get("/hojadecosto/ciftiempos/{identificador}", "Hoja_De_CostosController@cifTiempos");
    Route::get("/hojadecosto/unitario/", "Hoja_De_CostosController@unitarioTotal");
    Route::get("/hojadecosto/detalle/", "Hoja_De_CostosController@hojaDetalle");
    Route::get("/hojadecosto/unitariogen/", "Hoja_De_CostosController@unitarioTotalGen");
    Route::get("/hojadecosto/detallegen/", "Hoja_De_CostosController@hojaDetalleGen");

    Route::get("/simulacion", "Tb_simulacionController@index");
    Route::post("/simulacion/store", "Tb_simulacionController@store");
    Route::post("/simulacion/estado", "Tb_simulacionController@estado");
    Route::get("/simulacion/selectArea", "Tb_simulacionController@selectArea");
    Route::put("/simulacion/update", "Tb_simulacionController@update");
    Route::get("/simulacion/ciftiempos/{identificador}", "Tb_simulacionController@cifTiempos");
    Route::get("/simulacion/unitario/", "Tb_simulacionController@unitarioTotal");
    Route::get("/simulacion/detalle/", "Tb_simulacionController@hojaDetalle");
    Route::get("/simulacion/unitariogen/", "Tb_simulacionController@unitarioTotalGen");
    Route::get("/simulacion/detallegen/", "Tb_simulacionController@hojaDetalleGen");
    Route::get("/simulacion/testcif", "Tb_simulacionController@testCif");

    Route::get("/rela", "Tb_rela_simulacionController@index");
    Route::get("/rela/listar", "Tb_rela_simulacionController@listar");
    Route::get("/rela/posibles", "Tb_rela_simulacionController@posibles");
    Route::get("/rela/posiblesprueba", "Tb_rela_simulacionController@posiblesprueba");
    Route::post("/rela/store", "Tb_rela_simulacionController@store");
    Route::put("/rela/update", "Tb_rela_simulacionController@update");
    Route::put("/rela/delete", "Tb_rela_simulacionController@delete");
    Route::get("/rela/selectArea", "Tb_rela_simulacionController@selectArea");

    Route::get("/ordenpedido", "Tb_orden_pedido_clienteController@index");
    Route::post("/ordenpedido/store", "Tb_orden_pedido_clienteController@store");
    Route::post("/ordenpedido/estado", "Tb_orden_pedido_clienteController@estado");
    Route::get("/ordenpedido/clientes", "Tb_orden_pedido_clienteController@clientes");
    Route::put("/ordenpedido/update", "Tb_orden_pedido_clienteController@update");
    Route::get("/ordenpedido/ciftiempos/{identificador}", "Tb_orden_pedido_clienteController@cifTiempos");

    Route::get("/ordenpedidocliente", "Tb_orden_pedido_cliente_detalleController@index");
    Route::get("/ordenpedidocliente/listar", "Tb_orden_pedido_cliente_detalleController@listar");
    Route::get("/ordenpedidocliente/listarpendientes", "Tb_orden_pedido_cliente_detalleController@listarPendientes");
    Route::get("/ordenpedidocliente/listarsobrantes", "Tb_orden_pedido_cliente_detalleController@listarSobrantes");
    Route::get("/ordenpedidocliente/listarcompletos", "Tb_orden_pedido_cliente_detalleController@listarCompletos");
    Route::get("/ordenpedidocliente/posibles", "Tb_orden_pedido_cliente_detalleController@posibles");
    Route::get("/ordenpedidocliente/costo", "Tb_orden_pedido_cliente_detalleController@costo");
    Route::post("/ordenpedidocliente/store", "Tb_orden_pedido_cliente_detalleController@store");
    Route::put("/ordenpedidocliente/update", "Tb_orden_pedido_cliente_detalleController@update");
    Route::put("/ordenpedidocliente/delete", "Tb_orden_pedido_cliente_detalleController@delete");

    Route::get("/cotizacion", "Tb_cotizacionController@index");
    Route::post("/cotizacion/store", "Tb_cotizacionController@store");
    Route::post("/cotizacion/estado", "Tb_cotizacionController@estado");
    Route::put("/cotizacion/update", "Tb_cotizacionController@update");
    Route::get("/cotizacion/clientes", "Tb_cotizacionController@clientes");

    Route::get("/cotizacioncliente", "Tb_detalle_cotizacionController@index");
    Route::get("/cotizacioncliente/listar", "Tb_detalle_cotizacionController@listar");
    Route::get("/cotizacioncliente/posibles", "Tb_detalle_cotizacionController@posibles");
    Route::get("/cotizacioncliente/precioproductos/{productoid}", "Tb_detalle_cotizacionController@precioproductos");
    Route::post("/cotizacioncliente/store", "Tb_detalle_cotizacionController@store");
    Route::put("/cotizacioncliente/update", "Tb_detalle_cotizacionController@update");
    Route::put("/cotizacioncliente/delete", "Tb_detalle_cotizacionController@delete");

    Route::get("/kardexproducto", "Tb_kardex_producto_terminadoController@index");
    Route::get("/kardexproducto/listar", "Tb_kardex_producto_terminadoController@listar");
    Route::get("/kardexproductoordenes", "Tb_kardex_producto_terminadoController@ordenes");
    Route::get("/kardexproductoempleados", "Tb_kardex_producto_terminadoController@empleados");
    Route::get("/kardexproductotodos", "Tb_kardex_producto_terminadoController@todos");
    Route::get("/kardexproducto/producto", "Tb_kardex_producto_terminadoController@producto");
    Route::get("/kardexproducto/productos/{identificador}", "Tb_kardex_producto_terminadoController@productos");
    Route::get("/kardexproducto/precioproductosorden", "Tb_kardex_producto_terminadoController@precioproductosorden");
    Route::get("/kardexproducto/precioproductospromedio", "Tb_kardex_producto_terminadoController@precioproductospromedio");
    Route::post("/kardexproducto/store", "Tb_kardex_producto_terminadoController@store");
    Route::get("/kardexproducto/parakardex/{identificador}", "Tb_kardex_producto_terminadoController@parakardex");

    Route::get("/kardexalmacengeneral", "Tb_kardex_almacenController@general");
    Route::get("/kardexalmacen", "Tb_kardex_almacenController@index");
    Route::get("/kardexalmacen/listar", "Tb_kardex_almacenController@listar");
    Route::get("/kardexalmacen/producto", "Tb_kardex_almacenController@producto");
    Route::get("/kardexalmacenordenes", "Tb_kardex_almacenController@ordenes");
    Route::get("/kardexalmacen/material/{identificador}", "Tb_kardex_almacenController@material");
    Route::get("/kardexalmacen/preciomaterialorden", "Tb_kardex_almacenController@preciomaterialorden");
    Route::get("/kardexalmacen/preciomaterialcompra", "Tb_kardex_almacenController@preciomaterialcompra");
    Route::get("/kardexalmacen/factura/{factura}", "Tb_kardex_almacenController@factura");
    Route::get("/kardexalmacen/materialfactura/{factura}", "Tb_kardex_almacenController@materialfactura");
    Route::get("/kardexalmacen/productofactura", "Tb_kardex_almacenController@productofactura");
    Route::post("/kardexalmacen/store", "Tb_kardex_almacenController@store");

    Route::get("/kardexproducciongeneral", "Tb_kardex_produccionController@general");
    Route::get("/kardexproduccion", "Tb_kardex_produccionController@index");
    Route::get("/kardexproduccion/listar", "Tb_kardex_produccionController@listar");
    Route::post("/kardexproduccion/store", "Tb_kardex_produccionController@store");

    Route::get("/inventario", "Tb_inventarioController@index");
    Route::post("/inventario/store", "Tb_inventarioController@store");
    Route::post("/inventario/estado", "Tb_inventarioController@estado");
    Route::get("/inventario/empleados", "Tb_inventarioController@empleados");

    Route::get("/inventariodetalle", "Tb_detalle_inventarioController@index");
    Route::get("/inventariodetalle/listar", "Tb_detalle_inventarioController@listar");
    Route::get("/inventariodetalle/listar2", "Tb_detalle_inventarioController@listar2");
    Route::post("/inventariodetalle/store", "Tb_detalle_inventarioController@store");
    Route::post("/inventariodetalle/verificar", "Tb_detalle_inventarioController@verificar1");
    Route::post("/inventariodetalle/observacion", "Tb_detalle_inventarioController@observacion");

    Route::get("/tiempoestandar", "Tb_tiempo_estandarController@index");
    Route::post("/tiempoestandar/store", "Tb_tiempo_estandarController@store");
    Route::get("/tiempoestandar/empleados", "Tb_tiempo_estandarController@empleados");
    Route::post("/tiempoestandar/estado", "Tb_tiempo_estandarController@estado");

    Route::get("/tiempoestandar/listarciclos", "Tb_detalle_tiempo_estandarController@listarciclos");
    Route::post("/tiempoestandar/guardarciclos", "Tb_detalle_tiempo_estandarController@guardarciclos");
    Route::get("/tiempoestandar/listarwesting", "Tb_detalle_tiempo_estandarController@listarwesting");
    Route::get("/tiempoestandar/habilidad", "Tb_detalle_tiempo_estandarController@habilidad");
    Route::get("/tiempoestandar/esfuerzo", "Tb_detalle_tiempo_estandarController@esfuerzo");
    Route::get("/tiempoestandar/condiciones", "Tb_detalle_tiempo_estandarController@condiciones");
    Route::get("/tiempoestandar/consistencia", "Tb_detalle_tiempo_estandarController@consistencia");
    Route::post("/tiempoestandar/guardarWestingHouse", "Tb_detalle_tiempo_estandarController@guardarWestingHouse");
    Route::get("/tiempoestandar/listarpds", "Tb_detalle_tiempo_estandarController@listarpds");
    Route::get("/tiempoestandar/esfuerzomental", "Tb_detalle_tiempo_estandarController@esfuerzomental");
    Route::get("/tiempoestandar/esfuerzofisico", "Tb_detalle_tiempo_estandarController@esfuerzofisico");
    Route::get("/tiempoestandar/suplementarios", "Tb_detalle_tiempo_estandarController@suplementarios");
    Route::get("/tiempoestandar/personales", "Tb_detalle_tiempo_estandarController@personales");
    Route::get("/tiempoestandar/espera", "Tb_detalle_tiempo_estandarController@espera");
    Route::post("/tiempoestandar/guardarPds", "Tb_detalle_tiempo_estandarController@guardarPds");
    Route::get("/tiempoestandardetalle/listardetalle", "Tb_detalle_tiempo_estandarController@listardetalle");

    Route::get("/vinculacion", "Tb_vinculacionesController@index");
    Route::get("/vinculacioninactiva", "Tb_vinculacionesController@vinculacionesInactivas");
    Route::post("/vinculacion/store", "Tb_vinculacionesController@store");
    Route::put("/vinculacion/update", "Tb_vinculacionesController@update");
    Route::put("/vinculacion/deactivate", "Tb_vinculacionesController@deactivate");
    Route::put("/vinculacion/activate", "Tb_vinculacionesController@activate");
    Route::get("/vinculacion/selectempleado", "Tb_vinculacionesController@selectEmpleado");
    Route::get("/vinculacion/selecteps", "Tb_vinculacionesController@selectEps");
    Route::get("/vinculacion/selectnivel", "Tb_vinculacionesController@selectNivel");
    Route::get("/vinculacion/selectpensiones", "Tb_vinculacionesController@selectPensiones");
    Route::get("/vinculacion/selectvinculacion", "Tb_vinculacionesController@selectvinculacion");

    Route::get("/nomina", "Tb_nominaController@index");
    Route::post("/nomina/calcular", "Tb_nominaController@calcularNomina");
    //Route::get("/nomina/calcular", "Tb_nominaController@calcularNomina");
    Route::post("/nomina/store", "Tb_nominaController@store");
    Route::put("/nomina/delete", "Tb_nominaController@delete");
    Route::post("/nomina/estado", "Tb_nominaController@estado");
    Route::get("/nomina/listardetalle", "Tb_detalle_nominaController@listardetalle");
    Route::get("/nomina/detalles", "Tb_detalle_nominaController@detalles");
    Route::get('/nomina/exportar/{idNomina}', 'Tb_detalle_nominaController@export');
    Route::get("/nomina/pruebadestajo", "Tb_nominaController@pruebadestajo");
    Route::get("/nomina/prueba", "Tb_nominaController@prueba");
    Route::get("/nomina/pruebacalculo", "Tb_nominaController@pruebacalculo");

    Route::get("/novedades", "Tb_novedadesController@index");
    Route::get("/novedades/gen", "Tb_novedadesController@index2");
    Route::get("/novedades/detallado", "Tb_novedadesController@detallado");
    Route::post("/novedades/store", "Tb_novedadesController@store");
    Route::put("/novedades/eliminar", "Tb_novedadesController@eliminar");
    Route::get("/novedades/salario", "Tb_novedadesController@selectSalario");
    Route::get("/novedades/selectempleado", "Tb_novedadesController@selectEmpleado");
    Route::get("/novedades/selecttipologia", "Tb_novedadesController@selectTipologia");
    Route::get("/novedades/selectextra", "Tb_novedadesController@selectExtra");

    Route::get("/configuracion", "Tb_configuracion_basicaController@index");
    Route::post("/configuracion/store", "Tb_configuracion_basicaController@store");
    Route::put("/configuracion/update", "Tb_configuracion_basicaController@update");
    Route::post("/configuracion/actualizar", "Tb_configuracion_basicaController@actualizar");
    Route::get("/configuracion/tiponomina", "Tb_configuracion_basicaController@tipoNomina");
    Route::get("/configuracion/cajacompensacion", "Tb_configuracion_basicaController@CajaCompensacion");
    Route::get("/configuracion/arl", "Tb_configuracion_basicaController@Arl");
    Route::get("/configuracion/eps", "Tb_configuracion_basicaController@Eps");
    Route::get("/configuracion/pensiones", "Tb_configuracion_basicaController@Pensiones");
    Route::get("/configuracion/nivelarl", "Tb_configuracion_basicaController@NivelArl");

    Route::get("/factores", "Tb_factoresController@index");
    Route::post("/factores/store", "Tb_factoresController@store");
    Route::put("/factores/update", "Tb_factoresController@update");
    Route::post("/factores/actualizar", "Tb_factoresController@actualizar");

    Route::get("/vistaPersonalizada", "Tb_vista_personalizadaController@index");
    Route::post("/vistaPersonalizada/store", "Tb_vista_personalizadaController@store");
    Route::post("/vistaPersonalizada/actualizar", "Tb_vista_personalizadaController@actualizar");
    Route::get("/vistaPersonalizada/pruebas", "Tb_vista_personalizadaController@pruebas");

//--------------------------------Seccion para el uso de la copia de simulador para el punto multiproducto -----------------------------------//

    Route::get("/simulador", "Tb_simuladorController@index");
    Route::post("/simulador/store", "Tb_simuladorController@store");
    Route::post("/simulador/estado", "Tb_simuladorController@estado");
    Route::get("/simulador/selectArea", "Tb_simuladorController@selectArea");
    Route::put("/simulador/update", "Tb_simuladorController@update");
    Route::get("/simulador/unitario/", "Tb_simuladorController@unitarioTotal");
    Route::get("/simulador/unitarioequilibrio/", "Tb_simuladorController@unitarioEquilibrio");
    Route::get("/simulador/detalle/", "Tb_simuladorController@hojaDetalle");
    Route::get("/simulador/unitariogen/", "Tb_simuladorController@unitarioTotalGen");
    Route::get("/simulador/detallegen/", "Tb_simuladorController@hojaDetalleGen");

    Route::get("/relaf", "Tb_rela_simuladorController@index");
    Route::get("/relaf/listar", "Tb_rela_simuladorController@listar");
    Route::get("/relaf/productos", "Tb_rela_simuladorController@productos");
    Route::get("/relaf/posibles", "Tb_rela_simuladorController@posibles");
    Route::get("/relaf/posiblesPrecios", "Tb_rela_simuladorController@posiblesPrecios");
    Route::post("/relaf/store", "Tb_rela_simuladorController@store");
    Route::put("/relaf/update", "Tb_rela_simuladorController@update");
    Route::put("/relaf/delete", "Tb_rela_simuladorController@delete");
    Route::get("/relaf/selectArea", "Tb_rela_simuladorController@selectArea");
    Route::get("/relaf/selectDetallado", "Tb_rela_simuladorController@selectDetallado");
    Route::get("/relaf/pruebasPosibles", "Tb_rela_simuladorController@pruebasPosibles");

//--------------------------------Cierre Seccion para el uso de la copia de simulador para el punto multiproducto -----------------------------------//

    Route::post("/simulaciones/storePuntoEquilibrio", "Tb_simulacionesController@storePuntoEquilibrio");
    Route::get("/simulaciones/listarPuntos", "Tb_simulacionesController@listarPuntos");
    Route::post("/simulaciones/storePrecioVenta", "Tb_simulacionesController@storePrecioVenta");
    Route::get("/simulaciones/listarPrecios", "Tb_simulacionesController@listarPrecios");
    Route::post("/simulaciones/storeLiquidez", "Tb_simulacionesController@storeLiquidez");
    Route::get("/simulaciones/listarLiquidez", "Tb_simulacionesController@listarLiquidez");
    Route::post("/simulaciones/storeEndeudamiento", "Tb_simulacionesController@storeEndeudamiento");
    Route::get("/simulaciones/listarEndeudamiento", "Tb_simulacionesController@listarEndeudamiento");
    Route::post("/simulaciones/storeRentabilidad", "Tb_simulacionesController@storeRentabilidad");
    Route::get("/simulaciones/listarRentabilidad", "Tb_simulacionesController@listarRentabilidad");
    Route::post("/simulaciones/storeRotacioninventario", "Tb_simulacionesController@storeRotacioninventario");
    Route::get("/simulaciones/listarRotacioninventario", "Tb_simulacionesController@listarRotacioninventario");
    Route::post("/simulaciones/storeRotacioncartera", "Tb_simulacionesController@storeRotacioncartera");
    Route::get("/simulaciones/listarRotacioncartera", "Tb_simulacionesController@listarRotacioncartera");
    Route::get("/simulaciones/posibles", "Tb_simulacionesController@posibles");
    Route::get("/simulaciones/unitariogen", "Tb_simulacionesController@unitariogen");

});

// comentario de funcion para compilar

/*Route::get('pruebaColas',function(){
    $nominaid=2;
    $tb_nomina=Tb_nomina::findOrFail($nominaid);
    $flag=$tb_nomina->tipo;

    $nominaFija='detalle_nomina_fija_';
    $nominaDestajo='detalle_nomina_destajo_';
    $xls='.xls';
    $fecha=date('Y-m-d_H_i_s');

    $tb_nomina->save();
    if ($flag==1){
        return (new DetalleNominaFija)->download('Nomina_Fija_'.date('Y-m-d_H_i_s').'.xlsx');
        echo var_dump($nominaid);
        }
    else{
        return (new DetalleNominaDestajo)->download('Nomina_Destajo_'.date('Y-m-d_H_i_s').'.xlsx');
    }
});*/

/*Route::get('noBorrar',function(){
    $tiempos = DB::table('tb_ciclos')
     ->where('tb_ciclos.idTiempoEstandar','=',2)
     ->avg('tiempo');
     echo "Prom Tiempos: ",$tiempos;

    $piezas = DB::table('tb_ciclos')
     ->where('tb_ciclos.idTiempoEstandar','=',2)
     ->avg('piezas');
     echo "Prom Piezas: ",$piezas;

     $tiempo_estandar= Tb_tiempo_estandar::find(2);
     $tiempoPiezas=$tiempo_estandar->tiempoPiezas;

     $tiempoPiezas=$tiempo_estandar->tiempoPiezas;
     if($tiempo_estandar->numeroPiezas != 0){
        $tiempoPiezas=(($tiempo_estandar->tiempoElemental/60)/$tiempo_estandar->numeroPiezas)*$tiempo_estandar->piezasPar;
     }
     else{
        $tiempoPiezas=1;
        //echo "No se puede dividir por cero!!";
     }
     echo "Tiempo Piezas: ",$tiempoPiezas;
});*/


//---------------------------------------------------------------------------//

//accesos para los usuarios que son empresarios


Route::group(['middleware' => ['Empresario']], function () {
    //accesos para los usuarios que son empresarios

    Route::get("/financiera", "Tb_informacion_financieraController@index");
    Route::put("/financiera/update", "Tb_informacion_financieraController@update");
    Route::post("/financiera/actualizar", "Tb_informacion_financieraController@actualizar");

    Route::get("/proceso", "Tb_procesoController@index");
    Route::post("/proceso/store", "Tb_procesoController@store");
    Route::put("/proceso/update", "Tb_procesoController@update");
    Route::put("/proceso/deactivate", "Tb_procesoController@deactivate");
    Route::put("/proceso/activate", "Tb_procesoController@activate");
    Route::get("/proceso/selectProceso", "Tb_procesoController@selectProceso");

    Route::get("/perfil", "Tb_perfilController@index");
    Route::post("/perfil/store", "Tb_perfilController@store");
    Route::put("/perfil/update", "Tb_perfilController@update");
    Route::put("/perfil/deactivate", "Tb_perfilController@deactivate");
    Route::put("/perfil/activate", "Tb_perfilController@activate");
    Route::get("/perfil/selectRelacion/{id}", "Tb_perfilController@selectRelacion");

    Route::get("/unidad", "Tb_unidad_baseController@index");
    Route::post("/unidad/store", "Tb_unidad_baseController@store");
    Route::put("/unidad/update", "Tb_unidad_baseController@update");
    Route::put("/unidad/deactivate", "Tb_unidad_baseController@deactivate");
    Route::put("/unidad/activate", "Tb_unidad_baseController@activate");
    Route::get("/unidad/selectUnidad", "Tb_unidad_baseController@selectUnidad");

    Route::get("/materia", "Tb_tipo_materiaController@index");
    Route::post("/materia/store", "Tb_tipo_materiaController@store");
    Route::put("/materia/update", "Tb_tipo_materiaController@update");
    Route::put("/materia/deactivate", "Tb_tipo_materiaController@deactivate");
    Route::put("/materia/activate", "Tb_tipo_materiaController@activate");
    Route::get("/materia/selectUnidad", "Tb_tipo_materiaController@selectMateria");

    Route::get("/gestionmateria", "Tb_gestion_materia_primaController@index");
    Route::post("/gestionmateria/store", "Tb_gestion_materia_primaController@store");
    Route::put("/gestionmateria/update", "Tb_gestion_materia_primaController@update");
    Route::put("/gestionmateria/deactivate", "Tb_gestion_materia_primaController@deactivate");
    Route::put("/gestionmateria/activate", "Tb_gestion_materia_primaController@activate");
    Route::get("/gestionmateria/selectTipoMateria", "Tb_gestion_materia_primaController@selectTipoMateria");
    Route::get("/gestionmateria/selectUnidadBase", "Tb_gestion_materia_primaController@selectUnidadBase");
    Route::get("/gestionmateria/selectGestionMateria", "Tb_gestion_materia_primaController@selectGestionMateria");

    Route::get("/coleccion", "Tb_coleccionController@index");
    Route::post("/coleccion/store", "Tb_coleccionController@store");
    Route::put("/coleccion/update", "Tb_coleccionController@update");
    Route::put("/coleccion/deactivate", "Tb_coleccionController@deactivate");
    Route::put("/coleccion/activate", "Tb_coleccionController@activate");
    Route::get("/coleccion/selectColeccion", "Tb_coleccionController@selectColeccion");

    Route::get("/producto", "Tb_productoController@index");
    Route::post("/producto/store", "Tb_productoController@store");
    Route::put("/producto/update", "Tb_productoController@update");
    Route::put("/producto/deactivate", "Tb_productoController@deactivate");
    Route::put("/producto/activate", "Tb_productoController@activate");
    Route::get("/producto/selectProducto", "Tb_productoController@selectProducto");

    Route::get("/manodeobraproducto", "Tb_mano_de_obra_productoController@index");
    Route::post("/manodeobraproducto/store", "Tb_mano_de_obra_productoController@store");
    Route::put("/manodeobraproducto/update", "Tb_mano_de_obra_productoController@update");
    Route::put("/manodeobraproducto/deactivate", "Tb_mano_de_obra_productoController@deactivate");
    Route::get("/manodeobraproducto/selectRelacionPerfil/{id}", "Tb_mano_de_obra_productoController@selectRelacionPerfil");
    Route::get("/manodeobraproducto/valorMinuto/{id}", "Tb_mano_de_obra_productoController@valorMinuto");

    Route::get("/materiaprimaproducto", "Tb_materia_prima_productoController@index");
    Route::post("/materiaprimaproducto/store", "Tb_materia_prima_productoController@store");
    Route::put("/materiaprimaproducto/update", "Tb_materia_prima_productoController@update");
    Route::put("/materiaprimaproducto/deactivate", "Tb_materia_prima_productoController@deactivate");
    Route::get("/materiaprimaproducto/selectMateriaPrimaProducto", "Tb_materia_prima_productoController@selectMateriaPrimaProducto");
    Route::get("/materiaprimaproducto/selectGestionMateria", "Tb_materia_prima_productoController@selectGestionMateria");
    Route::get("/materiaprimaproducto/valorPrecioBase/{id}", "Tb_materia_prima_productoController@valorPrecioBase");

    Route::get("/concepto", "Tb_concepto_cifController@index");
    Route::post("/concepto/store", "Tb_concepto_cifController@store");
    Route::put("/concepto/update", "Tb_concepto_cifController@update");
    Route::put("/concepto/deactivate", "Tb_concepto_cifController@deactivate");
    Route::put("/concepto/activate", "Tb_concepto_cifController@activate");
    Route::get("/concepto/selectConcepto", "Tb_concepto_cifController@selectConcepto");

    Route::get("/maquinaria", "Tb_maquinariaController@index");
    Route::post("/maquinaria/store", "Tb_maquinariaController@store");
    Route::put("/maquinaria/update", "Tb_maquinariaController@update");
    Route::put("/maquinaria/deactivate", "Tb_maquinariaController@deactivate");
    Route::put("/maquinaria/activate", "Tb_maquinariaController@activate");
    Route::get("/maquinaria/selectMaquinaria", "Tb_maquinariaController@selectMaquinaria");

    Route::get("/hojadecosto/total/{identificador}", "Hoja_De_CostosController@acumuladoTotal");
    Route::get("/hojadecosto/depreciacion/{identificador}", "Hoja_De_CostosController@maquinariaTotal");

    });


});
