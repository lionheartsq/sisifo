<?php

namespace App\Http\Controllers;

use App\Asientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AsientosController extends Controller
{
    //funcion para traer datos básicos de los asientos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $asientos = Asientos::where('asientos.estado','=','1')
            ->orderBy('asientos.id','desc')
            ->paginate(5);
        }
        else {
            $asientos = Asientos::where('asientos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('asientos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$asientos->total(),
                'current_page'  =>$asientos->currentPage(),
                'per_page'      =>$asientos->perPage(),
                'last_page'     =>$asientos->lastPage(),
                'from'          =>$asientos->firstItem(),
                'to'            =>$asientos->lastItem(),
            ],
                'asientos' => $asientos,
        ];
    }

    public function listado(){

        $asientos = Asientos::where('asientos.estado','=','1')
        ->orderBy('asientos.id','desc')
        ->get();

        return ['asientos' => $asientos];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Asientos=new Asientos();
        $Asientos->fecha=$request->fecha;
        $Asientos->concepto=$request->concepto;
        $Asientos->detalle=$request->detalle;
        $Asientos->tipologia=$request->tipologia;
        $Asientos->idEmpresa=$idEmpresa;
        $Asientos->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Asientos=Asientos::findOrFail($request->id);
        $Asientos->fecha=$request->fecha;
        $Asientos->concepto=$request->concepto;
        $Asientos->detalle=$request->detalle;
        $Asientos->tipologia=$request->tipologia;
        $Asientos->idEmpresa=$idEmpresa;
        $Asientos->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Asientos=Asientos::findOrFail($request->id);
        $Asientos->estado='2';
        $Asientos->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Asientos=Asientos::findOrFail($request->id);
        $Asientos->estado='1';
        $Asientos->save();
    }


}
