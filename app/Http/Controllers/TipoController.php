<?php

namespace App\Http\Controllers;

use App\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TipoController extends Controller
{
    //funcion para traer datos básicos de los tipo
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
            $tipo = Tipo::where('tipo.estado','=','1')
            ->orderBy('tipo.id','desc')
            ->paginate(5);
        }
        else {
            $tipo = Tipo::where('tipo.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tipo.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$tipo->total(),
                'current_page'  =>$tipo->currentPage(),
                'per_page'      =>$tipo->perPage(),
                'last_page'     =>$tipo->lastPage(),
                'from'          =>$tipo->firstItem(),
                'to'            =>$tipo->lastItem(),
            ],
                'tipo' => $tipo,
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

        $tipo = Tipo::where('tipo.estado','=','1')
        ->orderBy('tipo.id','desc')
        ->get();

        return ['tipo' => $tipo];
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
        $Tipo=new Tipo();
        $Tipo->nombre=$request->nombre;
        $Tipo->estado=$request->estado;
        $Tipo->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Tipo=Tipo::findOrFail($request->id);
        $Tipo->nombre=$request->nombre;
        $Tipo->estado=$request->estado;
        $Tipo->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Tipo=Tipo::findOrFail($request->id);
        $Tipo->estado='2';
        $Tipo->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Tipo=Tipo::findOrFail($request->id);
        $Tipo->estado='1';
        $Tipo->save();
    }
}
