<?php

namespace App\Http\Controllers;

use App\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{
    //funcion para traer datos básicos de los clientes
    public function index(Request $request)
    {
        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $clientes = Clientes::orderBy('clientes.id','desc')
            ->paginate(5);
        }
        else {
            $clientes = Clientes::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('clientes.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$clientes->total(),
                'current_page'  =>$clientes->currentPage(),
                'per_page'      =>$clientes->perPage(),
                'last_page'     =>$clientes->lastPage(),
                'from'          =>$clientes->firstItem(),
                'to'            =>$clientes->lastItem(),
            ],
                'clientes' => $clientes,
        ];
    }

    public function listado(){

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        $clientes = Clientes::where('clientes.estado','=','1')
        ->orderBy('clientes.id','desc')
        ->get();

        return ['clientes' => $clientes];
    }

    public function listadoFiltrado(Request $request){

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        $clientes = Clientes::where('clientes.estado','=','1')
        ->where('clientes.cedula','=',$request->cedula)
        ->orderBy('clientes.id','desc')
        ->get();

        return ['clientes' => $clientes];
    }

    public function store(Request $request){

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Clientes=new Clientes();
        $Clientes->cedula=$request->cedula;
        $Clientes->nombres=$request->nombres;
        $Clientes->apellidos=$request->apellidos;
        $Clientes->direccion=$request->direccion;
        $Clientes->idEmpresa=$idEmpresa;
        $Clientes->telefono=$request->telefono;
        $Clientes->correo=$request->correo;
        $Clientes->estado=1;
        $Clientes->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Clientes=Clientes::findOrFail($request->id);
        $Clientes->cedula=$request->cedula;
        $Clientes->nombres=$request->nombres;
        $Clientes->apellidos=$request->apellidos;
        $Clientes->direccion=$request->direccion;
        $Clientes->idEmpresa=$idEmpresa;
        $Clientes->telefono=$request->telefono;
        $Clientes->correo=$request->correo;
        $Clientes->estado=1;
        $Clientes->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Clientes=Clientes::findOrFail($request->id);
        $Clientes->estado='2';
        $Clientes->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Clientes=Clientes::findOrFail($request->id);
        $Clientes->estado='1';
        $Clientes->save();
    }


}
