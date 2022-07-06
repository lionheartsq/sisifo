<?php

namespace App\Http\Controllers;

use App\Grupos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GruposController extends Controller
{
    //funcion para traer datos básicos de los grupos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $grupos = Grupos::where('grupos.estado','=','1')
            ->orderBy('grupos.id','desc')
            ->paginate(5);
        }
        else {
            $grupos = Grupos::where('grupos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('grupos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$grupos->total(),
                'current_page'  =>$grupos->currentPage(),
                'per_page'      =>$grupos->perPage(),
                'last_page'     =>$grupos->lastPage(),
                'from'          =>$grupos->firstItem(),
                'to'            =>$grupos->lastItem(),
            ],
                'grupos' => $grupos,
        ];
    }

    public function listado(){

        $grupos = Grupos::where('grupos.estado','=','1')
        ->orderBy('grupos.id','desc')
        ->get();

        return ['grupos' => $grupos];
    }


}
