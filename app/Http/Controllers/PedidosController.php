<?php

namespace App\Http\Controllers;

use App\Pedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
    //funcion para traer datos básicos de los pedidos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $pedidos = Pedidos::join("empleados","pedidos.idVendedor","=","empleados.id")
            ->join("proveedores","pedidos.idProveedores","=","proveedores.id")
            ->join("tipofactura","pedidos.idTipoFactura","=","tipofactura.id")
            ->select("pedidos.id", "pedidos.consecutivo", "pedidos.fecha", "pedidos.valor", "pedidos.impuesto", "pedidos.total", "pedidos.idVendedor", "pedidos.idTipoFactura",
            "pedidos.idProveedores", "pedidos.idEmpresa", "pedidos.estado","empleados.id as idEmpleado","empleados.nombres as nombresVendedor", "tipofactura.detalle as tipoFactura",
            "empleados.apellidos as apellidosVendedor","proveedores.id as idProveedores","proveedores.razonSocial")
            ->orderBy('pedidos.id','desc')
            ->paginate(5);
        }
        else {
            $pedidos = Pedidos::join("empleados","pedidos.idVendedor","=","empleados.id")
            ->join("proveedores","pedidos.idProveedores","=","proveedores.id")
            ->join("tipofactura","pedidos.idTipoFactura","=","tipofactura.id")
            ->select("pedidos.id", "pedidos.consecutivo", "pedidos.fecha", "pedidos.valor", "pedidos.impuesto", "pedidos.total", "pedidos.idVendedor", "pedidos.idTipoFactura",
            "pedidos.idProveedores", "pedidos.idEmpresa", "pedidos.estado","empleados.id as idEmpleado","empleados.nombres as nombresVendedor", "tipofactura.detalle as tipoFactura",
            "empleados.apellidos as apellidosVendedor","proveedores.id as idProveedores","proveedores.razonSocial")
            ->where('pedidos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('pedidos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$pedidos->total(),
                'current_page'  =>$pedidos->currentPage(),
                'per_page'      =>$pedidos->perPage(),
                'last_page'     =>$pedidos->lastPage(),
                'from'          =>$pedidos->firstItem(),
                'to'            =>$pedidos->lastItem(),
            ],
                'pedidos' => $pedidos,
        ];
    }

    public function listado(){
        $pedidos = Pedidos::join("empleados","pedidos.idVendedor","=","empleados.id")
        ->join("proveedores","pedidos.idProveedores","=","proveedores.id")
        ->join("tipofactura","pedidos.idTipoFactura","=","tipofactura.id")
        ->select("pedidos.id", "pedidos.consecutivo", "pedidos.fecha", "pedidos.valor", "pedidos.impuesto", "pedidos.total", "pedidos.idVendedor", "pedidos.idTipoFactura",
        "pedidos.idProveedores", "pedidos.idEmpresa", "pedidos.estado","empleados.id as idEmpleado","empleados.nombres as nombresVendedor", "tipofactura.detalle as tipoFactura",
        "empleados.apellidos as apellidosVendedor","proveedores.id as idProveedores","proveedores.razonSocial")
        ->where('pedidos.estado','=','1')
        ->orderBy('pedidos.id','desc')
        ->get();

        return ['pedidos' => $pedidos];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Pedidos=new Pedidos();
        $Pedidos->consecutivo=$request->consecutivo;
        $Pedidos->fecha=$request->fecha;
        $Pedidos->valor=$request->valor;
        $Pedidos->impuesto=$request->impuesto;
        $Pedidos->total=$request->total;
        $Pedidos->idVendedor=$request->idEmpleados;
        $Pedidos->idTipoFactura=$request->idTipofactura;
        $Pedidos->idProveedores=$request->idProveedores;
        $Pedidos->estado=1;
        $Pedidos->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Pedidos=Pedidos::findOrFail($request->id);
        $Pedidos->consecutivo=$request->consecutivo;
        $Pedidos->fecha=$request->fecha;
        $Pedidos->valor=$request->valor;
        $Pedidos->impuesto=$request->impuesto;
        $Pedidos->total=$request->total;
        $Pedidos->idVendedor=$request->idEmpleados;
        $Pedidos->idTipoFactura=$request->idTipofactura;
        $Pedidos->idProveedores=$request->idProveedores;
        $Pedidos->estado=1;
        $Pedidos->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Pedidos=Pedidos::findOrFail($request->id);
        $Pedidos->estado='2';
        $Pedidos->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Pedidos=Pedidos::findOrFail($request->id);
        $Pedidos->estado='1';
        $Pedidos->save();
    }
}
