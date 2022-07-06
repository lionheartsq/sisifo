<?php

namespace App\Http\Controllers;

use App\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientesController extends Controller
{
    //funcion para traer datos básicos de los clientes
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $clientes = Clientes::where('clientes.estado','=','1')
            ->orderBy('clientes.id','desc')
            ->paginate(5);
        }
        else {
            $clientes = Clientes::where('clientes.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('clientes.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$clientes->total(),
                'current_page'  =>$clientes->currentPage(),
                'per_page'      =>$clientes->perPage(),
                'last_page'     =>$clientes->lastPage(),
                'from'          =>$clientes->firstItem(),
                'to'            =>$clientes->lastItem(),
            ],
                'clientes' => $clientes,
        ];
    }

    public function listado(){

        $clientes = Clientes::where('clientes.estado','=','1')
        ->orderBy('clientes.id','desc')
        ->get();

        return ['clientes' => $clientes];
    }


}
