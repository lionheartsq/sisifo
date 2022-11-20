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

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Facturas=new Facturas();
        $Facturas->consecutivo=$request->consecutivo;
        $Facturas->fecha=$request->fecha;
        $Facturas->valor=$request->valor;
        $Facturas->impuesto=$request->impuesto;
        $Facturas->total=$request->total;
        $Facturas->vendedor=$request->vendedor;
        $Facturas->idVendedor=$request->idVendedor;
        $Facturas->tipoFactura=$request->tipoFactura;
        $Facturas->idClientes=$request->idClientes;
        $Facturas->idEmpresa=$idEmpresa;
        $Facturas->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Facturas=Facturas::findOrFail($request->id);
        $Facturas->consecutivo=$request->consecutivo;
        $Facturas->fecha=$request->fecha;
        $Facturas->valor=$request->valor;
        $Facturas->impuesto=$request->impuesto;
        $Facturas->total=$request->total;
        $Facturas->vendedor=$request->vendedor;
        $Facturas->idVendedor=$request->idVendedor;
        $Facturas->tipoFactura=$request->tipoFactura;
        $Facturas->idClientes=$request->idClientes;
        $Facturas->idEmpresa=$idEmpresa;
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
