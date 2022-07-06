<?php

namespace App\Http\Controllers;

use App\Asientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsientosController extends Controller
{
    //funcion para traer datos básicos de los asientos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $asientos = Asientos::where('asientos.estado','=','1')
            ->orderBy('asientos.id','desc')
            ->paginate(5);
        }
        else {
            $asientos = Asientos::where('asientos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('asientos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$asientos->total(),
                'current_page'  =>$asientos->currentPage(),
                'per_page'      =>$asientos->perPage(),
                'last_page'     =>$asientos->lastPage(),
                'from'          =>$asientos->firstItem(),
                'to'            =>$asientos->lastItem(),
            ],
                'asientos' => $asientos,
        ];
    }

    public function listado(){

        $asientos = Asientos::where('asientos.estado','=','1')
        ->orderBy('asientos.id','desc')
        ->get();

        return ['asientos' => $asientos];
    }


}
