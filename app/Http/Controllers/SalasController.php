<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Salas;


class SalasController extends Controller
{
    //
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $salas = Salas::where('salas.estado','=','1')
            ->orderBy('salas.id','desc')
            ->paginate(5);
        }
        else {
            $salas = Salas::where('salas.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('salas.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$salas->total(),
                'current_page'  =>$salas->currentPage(),
                'per_page'      =>$salas->perPage(),
                'last_page'     =>$salas->lastPage(),
                'from'          =>$salas->firstItem(),
                'to'            =>$salas->lastItem(),
            ],
                'salas' => $salas,
        ];
    }

    public function listado(){

        $salas = Salas::where('salas.estado','=','1')
        ->orderBy('salas.id','desc')
        ->get();

        return ['salas' => $salas];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $salas=new Salas();
        $salas->nombre=$request->nombre;
        $salas->ubicacion=$request->ubicacion;
        $salas->descripcion=$request->descripcion;
        $salas->estado='1';
        $salas->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $salas=Salas::findOrFail($request->id);
        $salas->nombre=$request->nombre;
        $salas->ubicacion=$request->ubicacion;
        $salas->descripcion=$request->descripcion;
        $salas->estado='1';
        $salas->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $salas=Salas::findOrFail($request->id);
        $salas->estado='0';
        $salas->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $salas=Salas::findOrFail($request->id);
        $salas->estado='1';
        $salas->save();
    }

    public function selectsalas(){
        $idSalas = Salas::where('estado','=','1')
        ->select('id as idSalas','salas')->orderBy('salas','asc')->get();

        return ['salas' => $idSalas];
    }

}



