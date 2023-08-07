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
            $pedidos = Pedidos::orderBy('pedidos.id','desc')
            ->paginate(5);
        }
        else {
            $pedidos = Pedidos::where('pedidos.estado','=','1')
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

        $pedidos = Pedidos::where('pedidos.estado','=','1')
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
        $Pedidos->total=$total;
        $Pedidos->vendedor=$vendedor;
        $Pedidos->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Pedidos=Pedidos::findOrFail($request->id);
        $Pedidos->cedula=$request->cedula;
        $Pedidos->nombres=$request->nombres;
        $Pedidos->apellidos=$request->apellidos;
        $Pedidos->direccion=$request->direccion;
        $Pedidos->idEmpresa=$idEmpresa;
        $Pedidos->correo=$correo;
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
