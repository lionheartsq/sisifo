<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $empresa=Empresa::findOrFail($request->id);
        $empresa->razonSocial=$request->razonSocial;
        $empresa->representante=$request->representante;
        $empresa->nit=$request->nit;
        $empresa->regimen=$request->regimen;
        $empresa->direccion=$request->direccion;
        $empresa->telefonos=$request->telefonos;
        $empresa->tipo=$request->tipo;
        $empresa->save();
    }

}
