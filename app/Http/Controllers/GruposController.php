<?php

namespace App\Http\Controllers;

use App\Grupos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GruposController extends Controller
{
    //funcion para traer datos básicos de los grupos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $grupos = Grupos::orderBy('grupos.id','desc')
            ->paginate(5);
        }
        else {
            $grupos = Grupos::where('grupos.estado','=','1')
            ->orderBy('grupos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$grupos->total(),
                'current_page'  =>$grupos->currentPage(),
                'per_page'      =>$grupos->perPage(),
                'last_page'     =>$grupos->lastPage(),
                'from'          =>$grupos->firstItem(),
                'to'            =>$grupos->lastItem(),
            ],
                'grupos' => $grupos,
        ];
    }

    public function listado(){

        $grupos = Grupos::where('grupos.estado','=','1')
        ->orderBy('grupos.detalleGrupos','asc')
        ->get();

        return ['grupos' => $grupos];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Grupos=new Grupos();
        $Grupos->detalleGrupos=$request->detalleGrupos;
        $Grupos->idEmpresa=$idEmpresa;
        $Grupos->estado=1;
        $Grupos->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Grupos=Grupos::findOrFail($request->id);
        $Grupos->detalleGrupos=$request->detalleGrupos;
        $Grupos->idEmpresa=$idEmpresa;
        $Grupos->estado=1;
        $Grupos->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Grupos=Grupos::findOrFail($request->id);
        $Grupos->estado='2';
        $Grupos->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Grupos=Grupos::findOrFail($request->id);
        $Grupos->estado='1';
        $Grupos->save();
    }


}
