<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmpresaController extends Controller
{
    //funcion para traer datos básicos de los empresa
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;

        if ($buscar=='') {
            $empresa = Empresa::where('empresa.estado','=','1')
            ->get();
        }
        else {
            $empresa = Empresa::where('empresa.estado','=','1')
            ->get();
        }

        foreach($empresa as $item){
            $id=$item['id'];
            $razonSocial=$item['razonSocial'];
            $representante=$item['representante'];
            $nit=$item['nit'];
            $regimen=$item['regimen'];
            $direccion=$item['direccion'];
            $telefonos=$item['telefonos'];
            $tipo=$item['tipo'];
        }

        return [
            'id' => $id,
            'razonSocial' => $razonSocial,
            'representante'=>$representante,
            'nit'=>$nit,
            'regimen'=>$regimen,
            'direccion'=>$direccion,
            'telefonos'=>$telefonos,
            'tipo'=>$tipo,
        ];
    }

    public function listado(){

        $empresa = Empresa::where('empresa.estado','=','1')
        ->orderBy('empresa.id','desc')
        ->get();

        return ['empresa' => $empresa];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Empresa=new Empresa();
        $Empresa->razonSocial=$request->razonSocial;
        $Empresa->representante=$request->representante;
        $Empresa->nit=$request->nit;
        $Empresa->regimen=$request->regimen;
        $Empresa->direccion=$request->direccion;
        $Empresa->telefonos=$request->telefonos;
        $Empresa->tipo=$request->tipo;
        $Empresa->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Empresa=Empresa::findOrFail($request->id);
        $Empresa->razonSocial=$request->razonSocial;
        $Empresa->representante=$request->representante;
        $Empresa->nit=$request->nit;
        $Empresa->regimen=$request->regimen;
        $Empresa->direccion=$request->direccion;
        $Empresa->telefonos=$request->telefonos;
        $Empresa->tipo=$request->tipo;
        $Empresa->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Empresa=Empresa::findOrFail($request->id);
        $Empresa->estado='2';
        $Empresa->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Empresa=Empresa::findOrFail($request->id);
        $Empresa->estado='1';
        $Empresa->save();
    }

}
