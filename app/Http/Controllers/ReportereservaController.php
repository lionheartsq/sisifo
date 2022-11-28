<?php

namespace App\Http\Controllers;

use App\Reportereserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportereservaController extends Controller
{
    //
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $reportereserva = Reportereserva::where('reportereserva.estado','=','1')
            ->join('reserva','reportereserva.idReservaNombre','=','reserva.id')
            ->join('salas','reportereserva.idSala','=','salas.id')
            ->select('reportereserva.id','reserva.nombre as idSala','reportereserva.idReservaNombre',
                    'reportereserva.idFecha','reportereserva.idObservaciones','reportereserva.estado',
                    'reportereserva.idFecha','reportereserva.idObservaciones')
            ->orderBy('reportereserva.id','desc')
            ->paginate(5);
        }
        else {
            $reportereserva = Reportereserva::where('reportereserva.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('reportereserva.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$reportereserva->total(),
                'current_page'  =>$reportereserva->currentPage(),
                'per_page'      =>$reportereserva->perPage(),
                'last_page'     =>$reportereserva->lastPage(),
                'from'          =>$reportereserva->firstItem(),
                'to'            =>$reportereserva->lastItem(),
            ],
                'reportereserva' => $reportereserva,
        ];
    }

    public function listado(){

        $reportereserva = Reportereserva::where('reportereserva.estado','=','1')
        ->orderBy('reportereserva.id','desc')
        ->get();

        return ['reportereserva' => $reportereserva];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $reportereserva=new Reportereserva();
        $reportereserva->idSala=$request->idSala;
        $reportereserva->reportereservaNombre=$request->reportereservaNombre;
        $reportereserva->fecha=$request->fecha;
        $reportereserva->observaciones=$request->observaciones;
        $reportereserva->estado=1;
        $reportereserva->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $reportereserva=Reportereserva::findOrFail($request->id);
        $reportereserva->idSala=$request->idSala;
        $reportereserva->reportereservaNombre=$request->reportereservaNombre;
        $reportereserva->fecha=$request->fecha;
        $reportereserva->observaciones=$request->observaciones;
        $reportereserva->estado=1;
        $reportereserva->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $reportereserva=Reportereserva::findOrFail($request->id);
        $reportereserva->estado='2';
        $reportereserva->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $reportereserva=Reportereserva::findOrFail($request->id);
        $reportereserva->estado='1';
        $reportereserva->save();
    }
    
}
