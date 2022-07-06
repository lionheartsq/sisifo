<?php

namespace App\Http\Controllers;

use App\Cobrosasientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobrosasientosController extends Controller
{
    //funcion para traer datos básicos de los cobrosasientos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $cobrosasientos = Cobrosasientos::where('cobrosasientos.estado','=','1')
            ->orderBy('cobrosasientos.id','desc')
            ->paginate(5);
        }
        else {
            $cobrosasientos = Cobrosasientos::where('cobrosasientos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('cobrosasientos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$cobrosasientos->total(),
                'current_page'  =>$cobrosasientos->currentPage(),
                'per_page'      =>$cobrosasientos->perPage(),
                'last_page'     =>$cobrosasientos->lastPage(),
                'from'          =>$cobrosasientos->firstItem(),
                'to'            =>$cobrosasientos->lastItem(),
            ],
                'cobrosasientos' => $cobrosasientos,
        ];
    }

    public function listado(){

        $cobrosasientos = Cobrosasientos::where('cobrosasientos.estado','=','1')
        ->orderBy('cobrosasientos.id','desc')
        ->get();

        return ['cobrosasientos' => $cobrosasientos];
    }


}
