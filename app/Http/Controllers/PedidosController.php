<?php

namespace App\Http\Controllers;

use App\Pedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{
    //funcion para traer datos básicos de los pedidos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $pedidos = Pedidos::where('pedidos.estado','=','1')
            ->orderBy('pedidos.id','desc')
            ->paginate(5);
        }
        else {
            $pedidos = Pedidos::where('pedidos.estado','=','1')
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

        $pedidos = Pedidos::where('pedidos.estado','=','1')
        ->orderBy('pedidos.id','desc')
        ->get();

        return ['pedidos' => $pedidos];
    }


}
