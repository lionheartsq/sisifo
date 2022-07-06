<?php

namespace App\Http\Controllers;

use App\Facturas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturasController extends Controller
{
    //funcion para traer datos básicos de los facturas
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $facturas = Facturas::where('facturas.estado','=','1')
            ->orderBy('facturas.id','desc')
            ->paginate(5);
        }
        else {
            $facturas = Facturas::where('facturas.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('facturas.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$facturas->total(),
                'current_page'  =>$facturas->currentPage(),
                'per_page'      =>$facturas->perPage(),
                'last_page'     =>$facturas->lastPage(),
                'from'          =>$facturas->firstItem(),
                'to'            =>$facturas->lastItem(),
            ],
                'facturas' => $facturas,
        ];
    }

    public function listado(){

        $facturas = Facturas::where('facturas.estado','=','1')
        ->orderBy('facturas.id','desc')
        ->get();

        return ['facturas' => $facturas];
    }


}
