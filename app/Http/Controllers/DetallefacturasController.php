<?php

namespace App\Http\Controllers;

use App\Detallefacturas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DetallefacturasController extends Controller
{
    //funcion para traer datos básicos de los detallefacturas
    public function index(Request $request)
    {
        // Cambios multiempresa
        $user = Auth::user();
        $empresa = $user->empresas->first();  // Obtiene la primera empresa de la relación

        if ($empresa) {
            $idEmpresa = $empresa->id;  // Accede a la propiedad "id" del objeto
            // Realizar operaciones con $idEmpresa
        }
        //cambios multiempresa

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
        // Cambios multiempresa
        $user = Auth::user();
        $empresa = $user->empresas->first();  // Obtiene la primera empresa de la relación

        if ($empresa) {
            $idEmpresa = $empresa->id;  // Accede a la propiedad "id" del objeto
            // Realizar operaciones con $idEmpresa
        }
        //cambios multiempresa


        $detallefacturas = Detallefacturas::where('detallefacturas.estado','=','1')
        ->orderBy('detallefacturas.id','desc')
        ->get();

        return ['detallefacturas' => $detallefacturas];
    }

    public function store(Request $request){
        // Cambios multiempresa
        $user = Auth::user();
        $empresa = $user->empresas->first();  // Obtiene la primera empresa de la relación

        if ($empresa) {
            $idEmpresa = $empresa->id;  // Accede a la propiedad "id" del objeto
            // Realizar operaciones con $idEmpresa
        }
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Detallefacturas=new Detallefacturas();
        $Detallefacturas->cantidad=$request->cantidad;
        $Detallefacturas->valor=$request->valor;
        $Detallefacturas->valorImpuesto=$request->valorImpuesto;
        $Detallefacturas->total=$request->total;
        $Detallefacturas->idFacturas=$idFacturas;
        $Detallefacturas->idProductos=$idProductos;
        $Detallefacturas->idEmpresas=$idEmpresas;
        $Detallefacturas->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Detallefacturas=Detallefacturas::findOrFail($request->id);
        $Detallefacturas->cantidad=$request->cantidad;
        $Detallefacturas->valor=$request->valor;
        $Detallefacturas->valorImpuesto=$request->valorImpuesto;
        $Detallefacturas->total=$request->total;
        $Detallefacturas->idFacturas=$idFacturas;
        $Detallefacturas->idProductos=$idProductos;
        $Detallefacturas->idEmpresas=$idEmpresas;
        $Detallefacturas->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Detallefacturas=Detallefacturas::findOrFail($request->id);
        $Detallefacturas->estado='2';
        $Detallefacturas->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Detallefacturas=Detallefacturas::findOrFail($request->id);
        $Detallefacturas->estado='1';
        $Detallefacturas->save();
    }


}
