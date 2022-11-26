<?php

namespace App\Http\Controllers;

use App\Ciudades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CiudadesController extends Controller
{
    //funcion para traer datos básicos de los ciudades
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $ciudades = Ciudades::join('departamentos','departamentos.id','=','ciudades.idDepartamentos')
            ->select('ciudades.id','ciudades.detalle','ciudades.idDepartamentos','ciudades.estado','departamentos.detalle as detalleDepartamento')
            ->orderBy('ciudades.id','desc')
            ->paginate(10);
        }
        else {
            $ciudades = Ciudades::join('departamentos','departamentos.id','=','ciudades.idDepartamentos')
            ->select('ciudades.id','ciudades.detalle','ciudades.idDepartamentos','ciudades.estado','departamentos.detalle as detalleDepartamento')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ciudades.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$ciudades->total(),
                'current_page'  =>$ciudades->currentPage(),
                'per_page'      =>$ciudades->perPage(),
                'last_page'     =>$ciudades->lastPage(),
                'from'          =>$ciudades->firstItem(),
                'to'            =>$ciudades->lastItem(),
            ],
                'ciudades' => $ciudades,
        ];
    }

    public function listado(){

        $ciudades = Ciudades::where('ciudades.estado','=','1')
        ->orderBy('ciudades.id','desc')
        ->get();

        return ['ciudades' => $ciudades];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Ciudades=new Ciudades();
        $Ciudades->detalle=$request->detalle;
        $Ciudades->idDepartamentos=$request->idDepartamentos;
        $Ciudades->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Ciudades=Ciudades::findOrFail($request->id);
        $Ciudades->detalle=$request->detalle;
        $Ciudades->idDepartamentos=$request->idDepartamentos;
        $Ciudades->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Ciudades=Ciudades::findOrFail($request->id);
        $Ciudades->estado='2';
        $Ciudades->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Ciudades=Ciudades::findOrFail($request->id);
        $Ciudades->estado='1';
        $Ciudades->save();
    }


}
