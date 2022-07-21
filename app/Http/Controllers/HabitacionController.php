<?php

namespace App\Http\Controllers;

use App\Habitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HabitacionController extends Controller
{
    //funcion para traer datos básicos de los habitacion
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $habitacion = Habitacion::where('habitacion.estado','=','1')
            ->orderBy('habitacion.id','desc')
            ->paginate(5);
        }
        else {
            $habitacion = Habitacion::where('habitacion.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('habitacion.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$habitacion->total(),
                'current_page'  =>$habitacion->currentPage(),
                'per_page'      =>$habitacion->perPage(),
                'last_page'     =>$habitacion->lastPage(),
                'from'          =>$habitacion->firstItem(),
                'to'            =>$habitacion->lastItem(),
            ],
                'habitacion' => $habitacion,
        ];
    }

    public function listado(){

        $habitacion = Habitacion::where('habitacion.estado','=','1')
        ->orderBy('habitacion.id','desc')
        ->get();

        return ['habitacion' => $habitacion];
    }


}
