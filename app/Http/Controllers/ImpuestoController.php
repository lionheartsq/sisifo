<?php

namespace App\Http\Controllers;

use App\Impuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ImpuestoController extends Controller
{
    //funcion para traer datos básicos de los impuesto
    public function index(Request $request)
    {
        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $impuesto = Impuesto::orderBy('impuesto.id','desc')
            ->paginate(5);
        }
        else {
            $impuesto = Impuesto::where('impuesto.estado','=','1')
            ->orderBy('impuesto.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$impuesto->total(),
                'current_page'  =>$impuesto->currentPage(),
                'per_page'      =>$impuesto->perPage(),
                'last_page'     =>$impuesto->lastPage(),
                'from'          =>$impuesto->firstItem(),
                'to'            =>$impuesto->lastItem(),
            ],
                'impuesto' => $impuesto,
        ];
    }

    public function listado(){

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa


        $impuesto = Impuesto::where('impuesto.estado','=','1')
        ->orderBy('impuesto.nombre','asc')
        ->get();

        return ['impuesto' => $impuesto];
    }

    public function store(Request $request){

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Impuesto=new Impuesto();
        $Impuesto->nombre=$request->nombre;
        $Impuesto->valor=$request->valor;
        $Impuesto->estado=1;
        $Impuesto->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa
        $Impuesto=Impuesto::findOrFail($request->id);
        $Impuesto->nombre=$request->nombre;
        $Impuesto->valor=$request->valor;
        $Impuesto->estado=1;
        $Impuesto->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Impuesto=Impuesto::findOrFail($request->id);
        $Impuesto->estado='2';
        $Impuesto->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Impuesto=Impuesto::findOrFail($request->id);
        $Impuesto->estado='1';
        $Impuesto->save();
    }


}
