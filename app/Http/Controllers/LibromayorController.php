<?php

namespace App\Http\Controllers;

use App\Libromayor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibromayorController extends Controller
{
    //funcion para traer datos básicos de los libromayor
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $libromayor = Libromayor::where('libromayor.estado','=','1')
            ->orderBy('libromayor.id','desc')
            ->paginate(5);
        }
        else {
            $libromayor = Libromayor::where('libromayor.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('libromayor.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$libromayor->total(),
                'current_page'  =>$libromayor->currentPage(),
                'per_page'      =>$libromayor->perPage(),
                'last_page'     =>$libromayor->lastPage(),
                'from'          =>$libromayor->firstItem(),
                'to'            =>$libromayor->lastItem(),
            ],
                'libromayor' => $libromayor,
        ];
    }

    public function listado(){

        $libromayor = Libromayor::where('libromayor.estado','=','1')
        ->orderBy('libromayor.id','desc')
        ->get();

        return ['libromayor' => $libromayor];
    }


}
