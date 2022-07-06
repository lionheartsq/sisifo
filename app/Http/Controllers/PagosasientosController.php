<?php

namespace App\Http\Controllers;

use App\Pagosasientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagosasientosController extends Controller
{
    //funcion para traer datos básicos de los pagosasientos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $pagosasientos = Pagosasientos::where('pagosasientos.estado','=','1')
            ->orderBy('pagosasientos.id','desc')
            ->paginate(5);
        }
        else {
            $pagosasientos = Pagosasientos::where('pagosasientos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('pagosasientos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$pagosasientos->total(),
                'current_page'  =>$pagosasientos->currentPage(),
                'per_page'      =>$pagosasientos->perPage(),
                'last_page'     =>$pagosasientos->lastPage(),
                'from'          =>$pagosasientos->firstItem(),
                'to'            =>$pagosasientos->lastItem(),
            ],
                'pagosasientos' => $pagosasientos,
        ];
    }

    public function listado(){

        $pagosasientos = Pagosasientos::where('pagosasientos.estado','=','1')
        ->orderBy('pagosasientos.id','desc')
        ->get();

        return ['pagosasientos' => $pagosasientos];
    }


}
