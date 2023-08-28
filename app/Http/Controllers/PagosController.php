<?php

namespace App\Http\Controllers;

use App\Pagos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PagosController extends Controller
{
    //funcion para traer datos básicos de los pagos
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
            $pagos = Pagos::where('pagos.estado','=','1')
            ->orderBy('pagos.id','desc')
            ->paginate(5);
        }
        else {
            $pagos = Pagos::where('pagos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('pagos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$pagos->total(),
                'current_page'  =>$pagos->currentPage(),
                'per_page'      =>$pagos->perPage(),
                'last_page'     =>$pagos->lastPage(),
                'from'          =>$pagos->firstItem(),
                'to'            =>$pagos->lastItem(),
            ],
                'pagos' => $pagos,
        ];
    }

    public function listado(){

        $pagos = Pagos::where('pagos.estado','=','1')
        ->orderBy('pagos.id','desc')
        ->get();

        return ['pagos' => $pagos];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Pagos=new Pagos();
        $Pagos->fechaAbono=$request->fechaAbono;
        $Pagos->valorPago=$request->valorPago;
        $Pagos->abono=$request->abono;
        $Pagos->idPedidos=$request->idPedidos;
        $Pagos->idEmpresa=$idEmpresa;
        $Pagos->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Pagos=Pagos::findOrFail($request->id);
        $Pagos->fechaAbono=$request->fechaAbono;
        $Pagos->valorPago=$request->valorPago;
        $Pagos->abono=$request->abono;
        $Pagos->idPedidos=$request->idPedidos;
        $Pagos->idEmpresa=$idEmpresa;
        $Pagos->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Pagos=Pagos::findOrFail($request->id);
        $Pagos->estado='2';
        $Pagos->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Pagos=Pagos::findOrFail($request->id);
        $Pagos->estado='1';
        $Pagos->save();
    }
}
