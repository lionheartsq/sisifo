<?php

namespace App\Http\Controllers;

use App\Detallepedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DetallepedidosController extends Controller
{
    //funcion para traer datos básicos de los detallepedidos
    public function index(Request $request)
    {
        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $detallepedidos = Detallepedidos::where('detallepedidos.estado','=','1')
            ->orderBy('detallepedidos.id','desc')
            ->paginate(5);
        }
        else {
            $detallepedidos = Detallepedidos::where('detallepedidos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('detallepedidos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$detallepedidos->total(),
                'current_page'  =>$detallepedidos->currentPage(),
                'per_page'      =>$detallepedidos->perPage(),
                'last_page'     =>$detallepedidos->lastPage(),
                'from'          =>$detallepedidos->firstItem(),
                'to'            =>$detallepedidos->lastItem(),
            ],
                'detallepedidos' => $detallepedidos,
        ];
    }

    public function listado(){

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa


        $detallepedidos = Detallepedidos::where('detallepedidos.estado','=','1')
        ->orderBy('detallepedidos.id','desc')
        ->get();

        return ['detallepedidos' => $detallepedidos];
    }

    public function store(Request $request){

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Detallefacturas=new Detallefacturas();
        $Detallefacturas->cantidad=$request->cantidad;
        $Detallefacturas->valor=$request->valor;
        $Detallefacturas->valorImpuesto=$request->valorImpuesto;
        $Detallefacturas->total=$request->total;
        $Detallefacturas->idPedidos=$idPedidos;
        $Detallefacturas->idProductos=$idProductos;
        $Detallefacturas->idEmpresas=$idEmpresas;
        $Detallefacturas->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa
        $Detallefacturas=Detallefacturas::findOrFail($request->id);
        $Detallefacturas->cantidad=$request->cantidad;
        $Detallefacturas->valor=$request->valor;
        $Detallefacturas->valorImpuesto=$request->valorImpuesto;
        $Detallefacturas->total=$request->total;
        $Detallefacturas->idPedidos=$idPedidos;
        $Detallefacturas->idProductos=$idProductos;
        $Detallefacturas->idEmpresas=$idEmpresas;
        $Detallefacturas->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Detallefacturas=Detallefacturas::findOrFail($request->id);
        $Detallefacturas->estado='2';
        $Detallefacturas->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Detallefacturas=Detallefacturas::findOrFail($request->id);
        $Detallefacturas->estado='1';
        $Detallefacturas->save();
    }
}
