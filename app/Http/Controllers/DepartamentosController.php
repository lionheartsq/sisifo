<?php

namespace App\Http\Controllers;

use App\Departamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DepartamentosController extends Controller
{
    //funcion para traer datos básicos de los departamentos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $departamentos = Departamentos::orderBy('departamentos.estado','asc')
            ->orderBy('departamentos.detalle','asc')
            ->paginate(5);
        }
        else {
            if($criterio != 'detalle' && $criterio != 'estado'){$criterio='detalle';}
            $buscar=($criterio != 'estado')?$buscar:(($buscar == 'activo')?'1':(($buscar == 'desactivado')?'2':$buscar));
            $departamentos = Departamentos::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('departamentos.estado','asc')
            ->orderBy('departamentos.detalle','asc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$departamentos->total(),
                'current_page'  =>$departamentos->currentPage(),
                'per_page'      =>$departamentos->perPage(),
                'last_page'     =>$departamentos->lastPage(),
                'from'          =>$departamentos->firstItem(),
                'to'            =>$departamentos->lastItem(),
            ],
                'departamentos' => $departamentos,
        ];
    }

    public function listado(){

        $departamentos = Departamentos::where('departamentos.estado','=','1')
        ->orderBy('departamentos.detalle','asc')
        ->get();

        return ['departamentos' => $departamentos];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Departamentos=new Departamentos();
        $Departamentos->detalle=$request->detalle;
        $Departamentos->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Departamentos=Departamentos::findOrFail($request->id);
        $Departamentos->detalle=$request->detalle;
        $Departamentos->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Departamentos=Departamentos::findOrFail($request->id);
        $Departamentos->estado='2';
        $Departamentos->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Departamentos=Departamentos::findOrFail($request->id);
        $Departamentos->estado='1';
        $Departamentos->save();
    }


}
