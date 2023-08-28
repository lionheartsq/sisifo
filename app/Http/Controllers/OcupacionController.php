<?php

namespace App\Http\Controllers;

use App\Ocupacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OcupacionController extends Controller
{
    //funcion para traer datos básicos de los ocupacion
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
            $ocupacion = Ocupacion::where('ocupacion.estado','=','1')
            ->orderBy('ocupacion.id','desc')
            ->paginate(5);
        }
        else {
            $ocupacion = Ocupacion::where('ocupacion.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ocupacion.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$ocupacion->total(),
                'current_page'  =>$ocupacion->currentPage(),
                'per_page'      =>$ocupacion->perPage(),
                'last_page'     =>$ocupacion->lastPage(),
                'from'          =>$ocupacion->firstItem(),
                'to'            =>$ocupacion->lastItem(),
            ],
                'ocupacion' => $ocupacion,
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


        $ocupacion = Ocupacion::where('ocupacion.estado','=','1')
        ->orderBy('ocupacion.id','desc')
        ->get();

        return ['ocupacion' => $ocupacion];
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
        $Ocupacion=new Ocupacion();
        $Ocupacion->detalle=$request->detalle;
        $Ocupacion->estado=$request->estado;
        $Ocupacion->fechaIngreso=$request->fechaIngreso;
        $Ocupacion->fechaSalida=$request->fechaSalida;
        $Ocupacion->horaIngreso=$horaIngreso;
        $Ocupacion->horaSalida=$horaSalida;
        $Ocupacion->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Ocupacion=Ocupacion::findOrFail($request->id);
        $Ocupacion->detalle=$request->detalle;
        $Ocupacion->estado=$request->estado;
        $Ocupacion->fechaIngreso=$request->fechaIngreso;
        $Ocupacion->fechaSalida=$request->fechaSalida;
        $Ocupacion->horaIngreso=$horaIngreso;
        $Ocupacion->horaSalida=$horaSalida;
        $Ocupacion->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Ocupacion=Ocupacion::findOrFail($request->id);
        $Ocupacion->estado='2';
        $Ocupacion->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Ocupacion=Ocupacion::findOrFail($request->id);
        $Ocupacion->estado='1';
        $Ocupacion->save();
    }
}
