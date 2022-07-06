<?php

namespace App\Http\Controllers;

use App\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedoresController extends Controller
{
    //funcion para traer datos básicos de los proveedores
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $proveedores = Proveedores::where('proveedores.estado','=','1')
            ->orderBy('proveedores.id','desc')
            ->paginate(5);
        }
        else {
            $proveedores = Proveedores::where('proveedores.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('proveedores.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$proveedores->total(),
                'current_page'  =>$proveedores->currentPage(),
                'per_page'      =>$proveedores->perPage(),
                'last_page'     =>$proveedores->lastPage(),
                'from'          =>$proveedores->firstItem(),
                'to'            =>$proveedores->lastItem(),
            ],
                'proveedores' => $proveedores,
        ];
    }

    public function listado(){

        $proveedores = Proveedores::where('proveedores.estado','=','1')
        ->orderBy('proveedores.id','desc')
        ->get();

        return ['proveedores' => $proveedores];
    }


}
