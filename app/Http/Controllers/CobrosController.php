<?php

namespace App\Http\Controllers;

use App\Cobros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CobrosController extends Controller
{
    //funcion para traer datos básicos de los cobros
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
            $cobros = Cobros::where('cobros.estado','=','1')
            ->orderBy('cobros.id','desc')
            ->paginate(5);
        }
        else {
            $cobros = Cobros::where('cobros.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('cobros.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$cobros->total(),
                'current_page'  =>$cobros->currentPage(),
                'per_page'      =>$cobros->perPage(),
                'last_page'     =>$cobros->lastPage(),
                'from'          =>$cobros->firstItem(),
                'to'            =>$cobros->lastItem(),
            ],
                'cobros' => $cobros,
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


        $cobros = Cobros::where('cobros.estado','=','1')
        ->orderBy('cobros.id','desc')
        ->get();

        return ['cobros' => $cobros];
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
        $Clientes=new Clientes();
        $Clientes->fechaAbono=$request->fechaAbono;
        $Clientes->valorCobro=$request->valorCobro;
        $Clientes->abono=$request->abono;
        $Clientes->idFacturas=$request->idFacturas;
        $Clientes->idEmpresa=$idEmpresa;
        $Clientes->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Clientes=Clientes::findOrFail($request->id);
        $Clientes->fechaAbono=$request->fechaAbono;
        $Clientes->valorCobro=$request->valorCobro;
        $Clientes->abono=$request->abono;
        $Clientes->idFacturas=$request->idFacturas;
        $Clientes->idEmpresa=$idEmpresa;
        $Clientes->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Clientes=Clientes::findOrFail($request->id);
        $Clientes->estado='2';
        $Clientes->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Clientes=Clientes::findOrFail($request->id);
        $Clientes->estado='1';
        $Clientes->save();
    }


}
