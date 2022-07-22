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
        $criterio= $request->criterio;

        if ($buscar=='') {
            $empresa = Empresa::where('empresa.estado','=','1')
            ->orderBy('empresa.id','desc')
            ->paginate(5);
        }
        else {
            $empresa = Empresa::where('empresa.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('empresa.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$empresa->total(),
                'current_page'  =>$empresa->currentPage(),
                'per_page'      =>$empresa->perPage(),
                'last_page'     =>$empresa->lastPage(),
                'from'          =>$empresa->firstItem(),
                'to'            =>$empresa->lastItem(),
            ],
                'empresa' => $empresa,
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
        $empresa->area=$request->area;
        $empresa->estado='1';
        $empresa->save();
    }

}
