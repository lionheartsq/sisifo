<?php

namespace App\Http\Controllers;

use App\Cobros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobrosController extends Controller
{
    //funcion para traer datos básicos de los cobros
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $cobros = Cobros::where('cobros.estado','=','1')
            ->orderBy('cobros.id','desc')
            ->paginate(5);
        }
        else {
            $cobros = Cobros::where('cobros.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('cobros.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$cobros->total(),
                'current_page'  =>$cobros->currentPage(),
                'per_page'      =>$cobros->perPage(),
                'last_page'     =>$cobros->lastPage(),
                'from'          =>$cobros->firstItem(),
                'to'            =>$cobros->lastItem(),
            ],
                'cobros' => $cobros,
        ];
    }

    public function listado(){

        $cobros = Cobros::where('cobros.estado','=','1')
        ->orderBy('cobros.id','desc')
        ->get();

        return ['cobros' => $cobros];
    }


}
