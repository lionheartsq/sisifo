<?php

namespace App\Http\Controllers;

use App\Impuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImpuestoController extends Controller
{
    //funcion para traer datos básicos de los impuesto
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $impuesto = Impuesto::where('impuesto.estado','=','1')
            ->orderBy('impuesto.id','desc')
            ->paginate(5);
        }
        else {
            $impuesto = Impuesto::where('impuesto.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('impuesto.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$impuesto->total(),
                'current_page'  =>$impuesto->currentPage(),
                'per_page'      =>$impuesto->perPage(),
                'last_page'     =>$impuesto->lastPage(),
                'from'          =>$impuesto->firstItem(),
                'to'            =>$impuesto->lastItem(),
            ],
                'impuesto' => $impuesto,
        ];
    }

    public function listado(){

        $impuesto = Impuesto::where('impuesto.estado','=','1')
        ->orderBy('impuesto.id','desc')
        ->get();

        return ['impuesto' => $impuesto];
    }


}
