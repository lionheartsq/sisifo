<?php

namespace App\Http\Controllers;

use App\Registros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrosController extends Controller
{
    //funcion para traer datos básicos de los registros
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $registros = Registros::where('registros.estado','=','1')
            ->orderBy('registros.id','desc')
            ->paginate(5);
        }
        else {
            $registros = Registros::where('registros.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('registros.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$registros->total(),
                'current_page'  =>$registros->currentPage(),
                'per_page'      =>$registros->perPage(),
                'last_page'     =>$registros->lastPage(),
                'from'          =>$registros->firstItem(),
                'to'            =>$registros->lastItem(),
            ],
                'registros' => $registros,
        ];
    }

    public function listado(){

        $registros = Registros::where('registros.estado','=','1')
        ->orderBy('registros.id','desc')
        ->get();

        return ['registros' => $registros];
    }


}
