<?php

namespace App\Http\Controllers;

use App\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    //funcion para traer datos básicos de los productos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $productos = Productos::where('productos.estado','=','1')
            ->orderBy('productos.id','desc')
            ->paginate(5);
        }
        else {
            $productos = Productos::where('productos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$productos->total(),
                'current_page'  =>$productos->currentPage(),
                'per_page'      =>$productos->perPage(),
                'last_page'     =>$productos->lastPage(),
                'from'          =>$productos->firstItem(),
                'to'            =>$productos->lastItem(),
            ],
                'productos' => $productos,
        ];
    }

    public function listado(){

        $productos = Productos::where('productos.estado','=','1')
        ->orderBy('productos.id','desc')
        ->get();

        return ['productos' => $productos];
    }


}
