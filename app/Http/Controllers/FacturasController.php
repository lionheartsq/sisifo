<?php

namespace App\Http\Controllers;

use App\Facturas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FacturasController extends Controller
{
    //funcion para traer datos básicos de los facturas
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $facturas = Facturas::where('facturas.estado','=','1')
            ->orderBy('facturas.id','desc')
            ->paginate(5);
        }
        else {
            $facturas = Facturas::where('facturas.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
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

        $facturas = Facturas::where('facturas.estado','=','1')
        ->orderBy('facturas.id','desc')
        ->get();

        return ['facturas' => $facturas];
    }

    public function ultimo(){
        $ultimo = Facturas::select('id')->orderBy('id', 'desc')->get();
        $cantidad = Facturas::count();
        $maximosalida=0;
        $maximo=0;

        if($cantidad==0){
            $maximosalida=1;
        }else{
            foreach($ultimo as $last){
                $maximo = $last->id;
                $maximosalida=$maximo+1;
            }
        }

        return [
                'consecutivoEsperado' => $maximosalida
                ];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $idVendedor=Auth::user()->id;
        $nombresVendedor=Auth::user()->nombres;
        $apellidosVendedor=Auth::user()->apellidos;
        $vendedor=$nombresVendedor." ".$apellidosVendedor;
        $Facturas=new Facturas();
        $Facturas->consecutivo=$request->consecutivo;
        $Facturas->fecha=$request->fecha;
        $Facturas->valor=$request->valor;
        $Facturas->impuesto=$request->impuesto;
        $Facturas->total=$request->total;
        $Facturas->vendedor=$vendedor;
        $Facturas->idVendedor=$idVendedor;
        $Facturas->observaciones=$request->observaciones;
        $Facturas->tipoFactura=1; //Factura tipo 1 contado, tipo 2 crédito en caso de update
        $Facturas->idClientes=$request->idClientes;
        $Facturas->idEmpresa=$idEmpresa;
        $Facturas->estado=1;
        $Facturas->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
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
        $Facturas->tipoFactura=$request->tipoFactura;
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
