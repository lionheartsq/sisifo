<?php

namespace App\Http\Controllers;

use App\Tipofactura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipofacturaController extends Controller
{
    //funcion para traer datos básicos de los tipofactura
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $tipofactura = Tipofactura::where('tipofactura.estado','=','1')
            ->orderBy('tipofactura.id','desc')
            ->paginate(5);
        }
        else {
            $tipofactura = Tipofactura::where('tipofactura.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tipofactura.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$tipofactura->total(),
                'current_page'  =>$tipofactura->currentPage(),
                'per_page'      =>$tipofactura->perPage(),
                'last_page'     =>$tipofactura->lastPage(),
                'from'          =>$tipofactura->firstItem(),
                'to'            =>$tipofactura->lastItem(),
            ],
                'tipofactura' => $tipofactura,
        ];
    }

    public function listado(){

        $tipofactura = Tipofactura::where('tipofactura.estado','=','1')
        ->orderBy('tipofactura.id','desc')
        ->get();

        return ['tipofactura' => $tipofactura];
    }


}
