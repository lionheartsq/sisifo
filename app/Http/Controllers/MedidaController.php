<?php

namespace App\Http\Controllers;

use App\Medida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MedidaController extends Controller
{
    //funcion para traer datos básicos de los medida
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $medida = Medida::where('medida.estado','=','1')
            ->orderBy('medida.id','desc')
            ->paginate(5);
        }
        else {
            $medida = Medida::where('medida.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('medida.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$medida->total(),
                'current_page'  =>$medida->currentPage(),
                'per_page'      =>$medida->perPage(),
                'last_page'     =>$medida->lastPage(),
                'from'          =>$medida->firstItem(),
                'to'            =>$medida->lastItem(),
            ],
                'medida' => $medida,
        ];
    }

    public function listado(){

        $medida = Medida::where('medida.estado','=','1')
        ->orderBy('medida.id','desc')
        ->get();

        return ['medida' => $medida];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Medida=new Medida();
        $Medida->nombre=$request->nombre;
        $Medida->estado=$request->estado;
        $Medida->idEmpresas=$idEmpresas;
        $Medida->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Medida=Medida::findOrFail($request->id);
        $Medida->nombre=$request->nombre;
        $Medida->estado=$request->estado;
        $Medida->idEmpresas=$idEmpresas;
        $Medida->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Medida=Medida::findOrFail($request->id);
        $Medida->estado='2';
        $Medida->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Medida=Medida::findOrFail($request->id);
        $Medida->estado='1';
        $Medida->save();
    }

}
