<?php

namespace App\Http\Controllers;

use App\Ciudades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CiudadesController extends Controller
{
    //funcion para traer datos básicos de los ciudades
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $ciudades = Ciudades::where('ciudades.estado','=','1')
            ->orderBy('ciudades.id','desc')
            ->paginate(5);
        }
        else {
            $ciudades = Ciudades::where('ciudades.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ciudades.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$ciudades->total(),
                'current_page'  =>$ciudades->currentPage(),
                'per_page'      =>$ciudades->perPage(),
                'last_page'     =>$ciudades->lastPage(),
                'from'          =>$ciudades->firstItem(),
                'to'            =>$ciudades->lastItem(),
            ],
                'ciudades' => $ciudades,
        ];
    }

    public function listado(){

        $ciudades = Ciudades::where('ciudades.estado','=','1')
        ->orderBy('ciudades.id','desc')
        ->get();

        return ['ciudades' => $ciudades];
    }


}
