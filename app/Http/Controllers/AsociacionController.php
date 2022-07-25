<?php

namespace App\Http\Controllers;

use App\Asociacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AsociacionController extends Controller
{
    //funcion para traer datos básicos de los asociacion
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $asociacion = Asociacion::where('asociacion.estado','=','1')
            ->orderBy('asociacion.id','desc')
            ->paginate(5);
        }
        else {
            $asociacion = Asociacion::where('asociacion.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('asociacion.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$asociacion->total(),
                'current_page'  =>$asociacion->currentPage(),
                'per_page'      =>$asociacion->perPage(),
                'last_page'     =>$asociacion->lastPage(),
                'from'          =>$asociacion->firstItem(),
                'to'            =>$asociacion->lastItem(),
            ],
                'asociacion' => $asociacion,
        ];
    }

    public function listado(){

        $asociacion = Asociacion::where('asociacion.estado','=','1')
        ->orderBy('asociacion.id','desc')
        ->get();

        return ['asociacion' => $asociacion];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Asociacion=new Asociacion();
        $Asociacion->idClientes=$request->idClientes;
        $Asociacion->idEmpresa=$idEmpresa;
        $Asociacion->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Asociacion=Asociacion::findOrFail($request->id);
        $Asociacion->idClientes=$request->idClientes;
        $Asociacion->idEmpresa=$idEmpresa;
        $Asociacion->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Asociacion=Asociacion::findOrFail($request->id);
        $Asociacion->estado='2';
        $Asociacion->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Asociacion=Asociacion::findOrFail($request->id);
        $Asociacion->estado='1';
        $Asociacion->save();
    }


}
