<?php

namespace App\Http\Controllers;

use App\Detallepedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallepedidosController extends Controller
{
    //funcion para traer datos básicos de los detallepedidos
    public function index(Request $request)
    {
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

        $detallepedidos = Detallepedidos::where('detallepedidos.estado','=','1')
        ->orderBy('detallepedidos.id','desc')
        ->get();

        return ['detallepedidos' => $detallepedidos];
    }


}
