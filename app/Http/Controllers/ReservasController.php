<?php

namespace App\Http\Controllers;

use App\Reservas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservasController extends Controller
{
    //funcion para traer datos básicos de los reservas
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $reservas = Reservas::where('reservas.estado','=','1')
            ->orderBy('reservas.id','desc')
            ->paginate(5);
        }
        else {
            $reservas = Reservas::where('reservas.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('reservas.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$reservas->total(),
                'current_page'  =>$reservas->currentPage(),
                'per_page'      =>$reservas->perPage(),
                'last_page'     =>$reservas->lastPage(),
                'from'          =>$reservas->firstItem(),
                'to'            =>$reservas->lastItem(),
            ],
                'reservas' => $reservas,
        ];
    }

    public function listado(){

        $reservas = Reservas::where('reservas.estado','=','1')
        ->orderBy('reservas.id','desc')
        ->get();

        return ['reservas' => $reservas];
    }


}
