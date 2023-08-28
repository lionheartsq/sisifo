<?php

namespace App\Http\Controllers;

use App\Libromayor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LibromayorController extends Controller
{
    //funcion para traer datos básicos de los libromayor
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
            $libromayor = Libromayor::where('libromayor.estado','=','1')
            ->orderBy('libromayor.id','desc')
            ->paginate(5);
        }
        else {
            $libromayor = Libromayor::where('libromayor.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('libromayor.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$libromayor->total(),
                'current_page'  =>$libromayor->currentPage(),
                'per_page'      =>$libromayor->perPage(),
                'last_page'     =>$libromayor->lastPage(),
                'from'          =>$libromayor->firstItem(),
                'to'            =>$libromayor->lastItem(),
            ],
                'libromayor' => $libromayor,
        ];
    }

    public function listado(){

        $libromayor = Libromayor::where('libromayor.estado','=','1')
        ->orderBy('libromayor.id','desc')
        ->get();

        return ['libromayor' => $libromayor];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Libromayor=new Libromayor();
        $Libromayor->valorEntrada=$request->valorEntrada;
        $Libromayor->valorSalida=$request->valorSalida;
        $Libromayor->acumulado=$request->acumulado;
        $Libromayor->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Libromayor=Libromayor::findOrFail($request->id);
        $Libromayor->valorEntrada=$request->valorEntrada;
        $Libromayor->valorSalida=$request->valorSalida;
        $Libromayor->acumulado=$request->acumulado;
        $Libromayor->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Libromayor=Libromayor::findOrFail($request->id);
        $Libromayor->estado='2';
        $Libromayor->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Libromayor=Libromayor::findOrFail($request->id);
        $Libromayor->estado='1';
        $Libromayor->save();
    }


}
