<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Empleados;
use App\Control;
use App\Historico;

class EmpleadosController extends Controller
{
    //
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $empleados = Empleados::orderBy('empleados.id','desc')
            ->paginate(5);
        }
        else {
            $empleados = Empleados::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('empleados.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$empleados->total(),
                'current_page'  =>$empleados->currentPage(),
                'per_page'      =>$empleados->perPage(),
                'last_page'     =>$empleados->lastPage(),
                'from'          =>$empleados->firstItem(),
                'to'            =>$empleados->lastItem(),
            ],
                'empleados' => $empleados,
        ];
    }

    public function listado(){

        $empleados = Empleados::where('empleados.estado','=','1')
        ->orderBy('empleados.id','desc')
        ->get();

        return ['empleados' => $empleados];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $empleados=new Empleados();
        $empleados->id=$request->id;
        $empleados->documento=$request->documento;
        $empleados->nombres=$request->nombres;
        $empleados->apellidos=$request->apellidos;
        $empleados->cargo=$request->cargo;
        $empleados->direccion=$request->direccion;
        $empleados->telefono=$request->telefono;
        $empleados->email=$request->email;
        $empleados->idEmpresa=$idEmpresa;
        $empleados->estado='1';
        $empleados->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $empleados=Empleados::findOrFail($request->id);
        $empleados->documento=$request->documento;
        $empleados->nombres=$request->nombres;
        $empleados->apellidos=$request->apellidos;
        $empleados->cargo=$request->cargo;
        $empleados->direccion=$request->direccion;
        $empleados->telefono=$request->telefono;
        $empleados->email=$request->email;
        $empleados->idEmpresa=$idEmpresa;
        $empleados->estado='1';
        $empleados->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $empleados=Empleados::findOrFail($request->id);
        $empleados->estado='2';
        $empleados->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $empleados=Empleados::findOrFail($request->id);
        $empleados->estado='1';
        $empleados->save();
    }

    public function selectEmpleados(){
        $idempleado = Empleados::where('estado','=','1')
        ->select('id as idEmpleado','empleados')->orderBy('empleados','asc')->get();

        return ['empleados' => $idempleado];
    }

}
