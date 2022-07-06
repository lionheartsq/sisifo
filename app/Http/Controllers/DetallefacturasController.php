<?php

namespace App\Http\Controllers;

use App\Detallefacturas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallefacturasController extends Controller
{
    //funcion para traer datos básicos de los detallefacturas
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $detallefacturas = Detallefacturas::where('detallefacturas.estado','=','1')
            ->orderBy('detallefacturas.id','desc')
            ->paginate(5);
        }
        else {
            $detallefacturas = Detallefacturas::where('detallefacturas.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('detallefacturas.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$detallefacturas->total(),
                'current_page'  =>$detallefacturas->currentPage(),
                'per_page'      =>$detallefacturas->perPage(),
                'last_page'     =>$detallefacturas->lastPage(),
                'from'          =>$detallefacturas->firstItem(),
                'to'            =>$detallefacturas->lastItem(),
            ],
                'detallefacturas' => $detallefacturas,
        ];
    }

    public function listado(){

        $detallefacturas = Detallefacturas::where('detallefacturas.estado','=','1')
        ->orderBy('detallefacturas.id','desc')
        ->get();

        return ['detallefacturas' => $detallefacturas];
    }


}
