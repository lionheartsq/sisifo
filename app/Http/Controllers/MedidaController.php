<?php

namespace App\Http\Controllers;

use App\Medida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedidaController extends Controller
{
    //funcion para traer datos básicos de los medida
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $medida = Medida::where('medida.estado','=','1')
            ->orderBy('medida.id','desc')
            ->paginate(5);
        }
        else {
            $medida = Medida::where('medida.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('medida.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$medida->total(),
                'current_page'  =>$medida->currentPage(),
                'per_page'      =>$medida->perPage(),
                'last_page'     =>$medida->lastPage(),
                'from'          =>$medida->firstItem(),
                'to'            =>$medida->lastItem(),
            ],
                'medida' => $medida,
        ];
    }

    public function listado(){

        $medida = Medida::where('medida.estado','=','1')
        ->orderBy('medida.id','desc')
        ->get();

        return ['medida' => $medida];
    }


}
