<?php

namespace App\Http\Controllers;

use App\Pagosasientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PagosasientosController extends Controller
{
    //funcion para traer datos básicos de los pagosasientos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $pagosasientos = Pagosasientos::where('pagosasientos.estado','=','1')
            ->orderBy('pagosasientos.id','desc')
            ->paginate(5);
        }
        else {
            $pagosasientos = Pagosasientos::where('pagosasientos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('pagosasientos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$pagosasientos->total(),
                'current_page'  =>$pagosasientos->currentPage(),
                'per_page'      =>$pagosasientos->perPage(),
                'last_page'     =>$pagosasientos->lastPage(),
                'from'          =>$pagosasientos->firstItem(),
                'to'            =>$pagosasientos->lastItem(),
            ],
                'pagosasientos' => $pagosasientos,
        ];
    }

    public function listado(){

        $pagosasientos = Pagosasientos::where('pagosasientos.estado','=','1')
        ->orderBy('pagosasientos.id','desc')
        ->get();

        return ['pagosasientos' => $pagosasientos];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Pagosasientos=new Pagosasientos();
        $Pagosasientos->idPagos=$request->idPagos;
        $Pagosasientos->idAsientos=$request->idAsientos;
        $Pagosasientos->idEmpresas=$idEmpresas;
        $Pagosasientos->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Pagosasientos=Pagosasientos::findOrFail($request->id);
        $Pagosasientos->idPagos=$request->idPagos;
        $Pagosasientos->idAsientos=$request->idAsientos;
        $Pagosasientos->idEmpresas=$idEmpresas;
        $Pagosasientos->save();
    }
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Pagosasientos=Pagosasientos::findOrFail($request->id);
        $Pagosasientos->estado='2';
        $Pagosasientos->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Pagosasientos=Pagosasientos::findOrFail($request->id);
        $Pagosasientos->estado='1';
        $Pagosasientos->save();
    }
}
