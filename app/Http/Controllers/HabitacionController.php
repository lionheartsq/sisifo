<?php

namespace App\Http\Controllers;

use App\Habitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HabitacionController extends Controller
{
    //funcion para traer datos básicos de los habitacion
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
            $habitacion = Habitacion::where('habitacion.estado','=','1')
            ->orderBy('habitacion.id','desc')
            ->paginate(5);
        }
        else {
            $habitacion = Habitacion::where('habitacion.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('habitacion.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$habitacion->total(),
                'current_page'  =>$habitacion->currentPage(),
                'per_page'      =>$habitacion->perPage(),
                'last_page'     =>$habitacion->lastPage(),
                'from'          =>$habitacion->firstItem(),
                'to'            =>$habitacion->lastItem(),
            ],
                'habitacion' => $habitacion,
        ];
    }

    public function listado(){

        $habitacion = Habitacion::where('habitacion.estado','=','1')
        ->orderBy('habitacion.id','desc')
        ->get();

        return ['habitacion' => $habitacion];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Habitacion=new Habitacion();
        $Habitacion->detalle=$request->detalle;
        $Habitacion->estado=$request->estado;
        $Habitacion->fecha=$request->fecha;
        $Habitacion->idTipo=$request->idTipo;
        $Habitacion->idEmpresas=$idEmpresas;
        $Habitacion->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Habitacion=Habitacion::findOrFail($request->id);
        $Habitacion->detalle=$request->detalle;
        $Habitacion->estado=$request->estado;
        $Habitacion->fecha=$request->fecha;
        $Habitacion->idTipo=$request->idTipo;
        $Habitacion->idEmpresas=$idEmpresas;
        $Habitacion->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Habitacion=Habitacion::findOrFail($request->id);
        $Habitacion->estado='2';
        $Habitacion->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Habitacion=Habitacion::findOrFail($request->id);
        $Habitacion->estado='1';
        $Habitacion->save();
    }


}
