<?php

namespace App\Http\Controllers;

use App\Tipofactura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TipofacturaController extends Controller
{
    //funcion para traer datos básicos de los tipofactura
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
            $tipofactura = Tipofactura::orderBy('tipofactura.id','desc')
            ->paginate(5);
        }
        else {
            $tipofactura = Tipofactura::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tipofactura.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$tipofactura->total(),
                'current_page'  =>$tipofactura->currentPage(),
                'per_page'      =>$tipofactura->perPage(),
                'last_page'     =>$tipofactura->lastPage(),
                'from'          =>$tipofactura->firstItem(),
                'to'            =>$tipofactura->lastItem(),
            ],
                'tipofactura' => $tipofactura,
        ];
    }

    public function listado(){

        $tipofactura = Tipofactura::where('tipofactura.estado','=','1')
        ->orderBy('tipofactura.id','desc')
        ->get();

        return ['tipofactura' => $tipofactura];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Tipofactura=new Tipofactura();
        $Tipofactura->detalle=$request->detalle;
        $Tipofactura->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Tipofactura=Tipofactura::findOrFail($request->id);
        $Tipofactura->detalle=$request->detalle;
        $Tipofactura->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Tipofactura=Tipofactura::findOrFail($request->id);
        $Tipofactura->estado='2';
        $Tipofactura->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Tipofactura=Tipofactura::findOrFail($request->id);
        $Tipofactura->estado='1';
        $Tipofactura->save();
    }
}
