<?php

namespace App\Http\Controllers;

use App\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductosController extends Controller
{
    //funcion para traer datos básicos de los productos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            # Modelo::join('tablaqueseune',basicamente un on)
            $productos = Productos::join('impuesto','productos.idImpuesto','=','impuesto.id')
            ->join('medida','productos.idMedida','=','medida.id')
            ->join('grupos','productos.idGrupos','=','grupos.id')
            ->select('productos.id','productos.plu','productos.detalle','productos.idMedida','productos.valorCompra','productos.pvp','productos.idImpuesto',
            'productos.idGrupos','productos.idEmpresa','productos.estado','impuesto.nombre as nombreImpuesto','medida.nombre as nombreMedida','grupos.detalleGrupos as nombreGrupos')
            ->orderBy('productos.id','desc')
            ->paginate(5);
        }
        else {
            $productos = Productos::join('impuesto','productos.idImpuesto','=','impuesto.id')
            ->join('medida','productos.idMedida','=','medida.id')
            ->join('grupos','productos.idGrupos','=','grupos.id')
            ->select('productos.id','productos.plu','productos.detalle','productos.idMedida','productos.valorCompra','productos.pvp','productos.idImpuesto',
            'productos.idGrupos','productos.idEmpresa','productos.estado','impuesto.nombre as nombreImpuesto','medida.nombre as nombreMedida','grupos.detalleGrupos as nombreGrupos')
            ->where('productos.estado','=','1')
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

        $productos = Productos::join('impuesto','productos.idImpuesto','=','impuesto.id')
        ->join('medida','productos.idMedida','=','medida.id')
        ->join('grupos','productos.idGrupos','=','grupos.id')
        ->select('productos.id','productos.plu','productos.detalle','productos.idMedida','productos.valorCompra','productos.pvp','productos.idImpuesto',
        'productos.idGrupos','productos.idEmpresa','productos.estado','impuesto.nombre as nombreImpuesto','medida.nombre as nombreMedida','grupos.detalleGrupos as nombreGrupos')
        ->where('productos.estado','=','1')
        ->orderBy('productos.id','desc')
        ->get();

        return ['productos' => $productos];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Productos=new Productos();
        $Productos->plu=$request->plu;
        $Productos->detalle=$request->detalle;
        $Productos->idMedida=$request->idMedida;
        $Productos->valorCompra=$request->valorCompra;
        $Productos->pvp=$request->pvp;
        $Productos->idGrupos=$request->idGrupos;
        $Productos->idImpuesto=$request->idImpuesto;
        $Productos->idEmpresa=$idEmpresa;
        $Productos->estado=1;
        $Productos->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Productos=Productos::findOrFail($request->id);
        $Productos->plu=$request->plu;
        $Productos->detalle=$request->detalle;
        $Productos->idMedida=$request->idMedida;
        $Productos->valorCompra=$request->valorCompra;
        $Productos->pvp=$request->pvp;
        $Productos->idGrupos=$request->idGrupos;
        $Productos->idImpuesto=$request->idImpuesto;
        $Productos->idEmpresa=$idEmpresa;
        $Productos->estado=1;
        $Productos->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Productos=Productos::findOrFail($request->id);
        $Productos->estado='2';
        $Productos->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Productos=Productos::findOrFail($request->id);
        $Productos->estado='1';
        $Productos->save();
    }
}
