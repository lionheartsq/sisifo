<?php

namespace App\Http\Controllers;

use App\Pagos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagosController extends Controller
{
    //funcion para traer datos básicos de los pagos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $pagos = Pagos::where('pagos.estado','=','1')
            ->orderBy('pagos.id','desc')
            ->paginate(5);
        }
        else {
            $pagos = Pagos::where('pagos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('pagos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$pagos->total(),
                'current_page'  =>$pagos->currentPage(),
                'per_page'      =>$pagos->perPage(),
                'last_page'     =>$pagos->lastPage(),
                'from'          =>$pagos->firstItem(),
                'to'            =>$pagos->lastItem(),
            ],
                'pagos' => $pagos,
        ];
    }

    public function listado(){

        $pagos = Pagos::where('pagos.estado','=','1')
        ->orderBy('pagos.id','desc')
        ->get();

        return ['pagos' => $pagos];
    }


}
