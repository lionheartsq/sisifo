<?php

namespace App\Http\Controllers;

use App\Ocupacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OcupacionController extends Controller
{
    //funcion para traer datos básicos de los ocupacion
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $ocupacion = Ocupacion::where('ocupacion.estado','=','1')
            ->orderBy('ocupacion.id','desc')
            ->paginate(5);
        }
        else {
            $ocupacion = Ocupacion::where('ocupacion.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ocupacion.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$ocupacion->total(),
                'current_page'  =>$ocupacion->currentPage(),
                'per_page'      =>$ocupacion->perPage(),
                'last_page'     =>$ocupacion->lastPage(),
                'from'          =>$ocupacion->firstItem(),
                'to'            =>$ocupacion->lastItem(),
            ],
                'ocupacion' => $ocupacion,
        ];
    }

    public function listado(){

        $ocupacion = Ocupacion::where('ocupacion.estado','=','1')
        ->orderBy('ocupacion.id','desc')
        ->get();

        return ['ocupacion' => $ocupacion];
    }


}
