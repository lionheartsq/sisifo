<?php

namespace App\Http\Controllers;

use App\Reservas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservasController extends Controller
{
    //funcion para traer datos básicos de los reservas
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $reservas = Reservas::where('reservas.estado','=','1')
            ->orderBy('reservas.id','desc')
            ->paginate(5);
        }
        else {
            $reservas = Reservas::where('reservas.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('reservas.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$reservas->total(),
                'current_page'  =>$reservas->currentPage(),
                'per_page'      =>$reservas->perPage(),
                'last_page'     =>$reservas->lastPage(),
                'from'          =>$reservas->firstItem(),
                'to'            =>$reservas->lastItem(),
            ],
                'reservas' => $reservas,
        ];
    }

    public function listado(){

        $reservas = Reservas::where('reservas.estado','=','1')
        ->orderBy('reservas.id','desc')
        ->get();

        return ['reservas' => $reservas];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Reservas=new Reservas();
        $Reservas->detalle=$request->detalle;
        $Reservas->estado=$request->estado;
        $Reservas->fecha=$request->fecha;
        $Reservas->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Reservas=Reservas::findOrFail($request->id);
        $Reservas->detalle=$request->detalle;
        $Reservas->estado=$request->estado;
        $Reservas->fecha=$request->fecha;
        $Reservas->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Reservas=Reservas::findOrFail($request->id);
        $Reservas->estado='2';
        $Reservas->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Reservas=Reservas::findOrFail($request->id);
        $Reservas->estado='1';
        $Reservas->save();
    }
}
