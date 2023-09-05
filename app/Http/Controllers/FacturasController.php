<?php

namespace App\Http\Controllers;

use App\Facturas;
use App\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FacturasController extends Controller
{
    //funcion para traer datos básicos de los facturas
    public function index(Request $request)
    {
        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $facturas = Facturas::orderBy('facturas.id','desc')
            ->paginate(5);
        }
        else {
            $facturas = Facturas::where('facturas.estado','=','1')
            ->orderBy('facturas.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$facturas->total(),
                'current_page'  =>$facturas->currentPage(),
                'per_page'      =>$facturas->perPage(),
                'last_page'     =>$facturas->lastPage(),
                'from'          =>$facturas->firstItem(),
                'to'            =>$facturas->lastItem(),
            ],
                'facturas' => $facturas,
        ];
    }

    public function listado(){

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa


        $facturas = Facturas::where('facturas.estado','=','1')
        ->orderBy('facturas.id','desc')
        ->get();

        return ['facturas' => $facturas];
    }

    public function ultimo(){
        $ultimo = Facturas::select('id','consecutivo')->orderBy('id', 'desc')->take(1)->get();
        $cantidad = Facturas::count();
        $maximosalida=0;
        $maximo=0;

        if($cantidad==0){
            $maximosalida=1;
        }else{
            foreach($ultimo as $last){
                $maximo = $last->consecutivo;
                $maximosalida=$maximo+1;
            }
        }

        return [
                'ultimo' => $ultimo,
                'cantidad' => $cantidad,
                'maximo' => $maximo,
                'consecutivoEsperado' => $maximosalida
                ];
    }

    public function store(Request $request){

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $idVendedor=Auth::user()->id;
        $nombresVendedor=Auth::user()->nombres;
        $apellidosVendedor=Auth::user()->apellidos;
        $vendedor=$nombresVendedor." ".$apellidosVendedor;
        $cedula=$request->cedula;

        $count_cliente=clientes::where('cedula','=',$cedula)->count();
        $id_clientes=clientes::where('cedula','=',$cedula)->select('id')->get();

        foreach($id_clientes as $vuelta){
            $idBusca = $vuelta->id;
            }

        if($count_cliente == 0){
            $Clientes=new Clientes();
            $Clientes->cedula=$request->cedula;
            $Clientes->nombres=$request->nombres;
            $Clientes->apellidos=$request->apellidos;
            $Clientes->direccion=$request->direccion;
            $Clientes->idEmpresa=$idEmpresa;
            $Clientes->telefono=$request->telefono;
            $Clientes->correo=$request->correo;
            $Clientes->estado=1;
            $Clientes->save();
            # ==================================
            # Aquí tenemos el id recién guardado :)
            # ==================================
            $idClientes = $Clientes->id;
        }else{
            $idClientes=$idBusca;
            $Clientes=Clientes::findOrFail($idClientes);
            $Clientes->cedula=$request->cedula;
            $Clientes->nombres=$request->nombres;
            $Clientes->apellidos=$request->apellidos;
            $Clientes->direccion=$request->direccion;
            $Clientes->idEmpresa=$idEmpresa;
            $Clientes->telefono=$request->telefono;
            $Clientes->correo=$request->correo;
            $Clientes->estado=1;
            $Clientes->save();
        }
        $Facturas=new Facturas();
        $Facturas->consecutivo=$request->consecutivo;
        $Facturas->fecha=$request->fecha;
        $Facturas->valor=$request->valor;
        $Facturas->impuesto=$request->impuesto;
        $Facturas->total=$request->total;
        $Facturas->vendedor=$vendedor;
        $Facturas->idVendedor=$idVendedor;
        $Facturas->observaciones=$request->observaciones;
        $Facturas->tipofactura=1; //Factura tipo 1 contado, tipo 2 crédito en caso de update
        $Facturas->idClientes=$idClientes;
        $Facturas->idEmpresa=$idEmpresa;
        $Facturas->estado=1;
        $Facturas->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa
        $idVendedor=Auth::user()->id;
        $nombres=Auth::user()->nombres;
        $apellidos=Auth::user()->apellidos;
        $vendedor=$nombres." ".$apellidos;
        $Facturas=Facturas::findOrFail($request->id);
        $Facturas->consecutivo=$request->consecutivo;
        $Facturas->fecha=$request->fecha;
        $Facturas->valor=$request->valor;
        $Facturas->impuesto=$request->impuesto;
        $Facturas->total=$request->total;
        $Facturas->vendedor=$vendedor;
        $Facturas->idVendedor=$idVendedor;
        $Facturas->observaciones=$request->observaciones;
        $Facturas->tipofactura=$request->tipofactura;
        $Facturas->idClientes=$request->idClientes;
        $Facturas->idEmpresa=$idEmpresa;
        $Facturas->estado=1;
        $Facturas->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Facturas=Facturas::findOrFail($request->id);
        $Facturas->estado='2';
        $Facturas->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Facturas=Facturas::findOrFail($request->id);
        $Facturas->estado='1';
        $Facturas->save();
    }


}
