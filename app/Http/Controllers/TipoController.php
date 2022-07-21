<?php

namespace App\Http\Controllers;

use App\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoController extends Controller
{
    //funcion para traer datos básicos de los tipo
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $tipo = Tipo::where('tipo.estado','=','1')
            ->orderBy('tipo.id','desc')
            ->paginate(5);
        }
        else {
            $tipo = Tipo::where('tipo.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tipo.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$tipo->total(),
                'current_page'  =>$tipo->currentPage(),
                'per_page'      =>$tipo->perPage(),
                'last_page'     =>$tipo->lastPage(),
                'from'          =>$tipo->firstItem(),
                'to'            =>$tipo->lastItem(),
            ],
                'tipo' => $tipo,
        ];
    }

    public function listado(){

        $tipo = Tipo::where('tipo.estado','=','1')
        ->orderBy('tipo.id','desc')
        ->get();

        return ['tipo' => $tipo];
    }


}
