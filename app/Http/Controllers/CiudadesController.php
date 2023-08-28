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
        // Cambios multiempresa
        $user = Auth::user();
        $empresa = $user->empresas->first();  // Obtiene la primera empresa de la relación

        if ($empresa) {
            $idEmpresa = $empresa->id;  // Accede a la propiedad "id" del objeto
            // Realizar operaciones con $idEmpresa
        }
        //cambios multiempresa

        //if(!$reque st        ->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $ciudades = Ciudades::join("departamentos","ciudades.idDepartamentos","=","departamentos.id")
            ->where('ciudades.estado','=','1')
            ->select('ciudades.id','ciudades.detalle','ciudades.estado','departamentos.detalle as idDepartamento')
            ->orderBy('ciudades.id','desc')
            ->paginate(5);
        }
        else {
            $ciudades = Ciudades::join("roles","users.idRol","=","roles.id")
            ->where('ciudades.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->select('ciudades.id','ciudades.detalle','ciudades.estado','departamentos.detalle as idDepartamento')
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
        // Cambios multiempresa
        $user = Auth::user();
        $empresa = $user->empresas->first();  // Obtiene la primera empresa de la relación

        if ($empresa) {
            $idEmpresa = $empresa->id;  // Accede a la propiedad "id" del objeto
            // Realizar operaciones con $idEmpresa
        }
        //cambios multiempresa

        $ciudades = Ciudades::where('ciudades.estado','=','1')
        ->orderBy('ciudades.id','desc')
        ->get();

        return ['ciudades' => $ciudades];
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
        $Ciudades=new Ciudades();
        $Ciudades->detalle=$request->detalle;
        $Ciudades->idDepartamentos=$idDepartamentos;
        $Ciudades->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Ciudades=Ciudades::findOrFail($request->id);
        $Ciudades->detalle=$request->detalle;
        $Ciudades->idDepartamentos=$idDepartamentos;
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
