<?php

namespace App\Http\Controllers;

use App\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProveedoresController extends Controller
{
    //funcion para traer datos básicos de los proveedores
    public function index(Request $request)
    {
        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $proveedores = Proveedores::orderBy('proveedores.id','desc')
            ->paginate(5);
        }
        else {
            $proveedores = Proveedores::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('proveedores.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$proveedores->total(),
                'current_page'  =>$proveedores->currentPage(),
                'per_page'      =>$proveedores->perPage(),
                'last_page'     =>$proveedores->lastPage(),
                'from'          =>$proveedores->firstItem(),
                'to'            =>$proveedores->lastItem(),
            ],
                'proveedores' => $proveedores,
        ];
    }

    public function listado(){

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa


        $proveedores = Proveedores::where('proveedores.estado','=','1')
        ->orderBy('proveedores.id','desc')
        ->get();

        return ['proveedores' => $proveedores];
    }

    public function store(Request $request){

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Proveedores=new Proveedores();
        $Proveedores->nit=$request->nit;
        $Proveedores->razonSocial=$request->razonSocial;
        $Proveedores->contacto=$request->contacto;
        $Proveedores->telefono=$request->telefono;
        $Proveedores->direccion=$request->direccion;
        $Proveedores->idEmpresa=$idEmpresa;
        $Proveedores->correo=$request->correo;
        $Proveedores->estado=1;
        $Proveedores->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa
        $Proveedores=Proveedores::findOrFail($request->id);
        $Proveedores->nit=$request->nit;
        $Proveedores->razonSocial=$request->razonSocial;
        $Proveedores->contacto=$request->contacto;
        $Proveedores->telefono=$request->telefono;
        $Proveedores->direccion=$request->direccion;
        $Proveedores->idEmpresa=$idEmpresa;
        $Proveedores->correo=$request->correo;
        $Proveedores->estado=1;
        $Proveedores->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Proveedores=Proveedores::findOrFail($request->id);
        $Proveedores->estado='2';
        $Proveedores->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Proveedores=Proveedores::findOrFail($request->id);
        $Proveedores->estado='1';
        $Proveedores->save();
    }
}
