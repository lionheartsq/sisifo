<?php

namespace App\Http\Controllers;

use App\Reserva;
use App\Salas;
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
        // $buscar= $request->buscar;
        // $criterio= $request->criterio;
    
        // if ($buscar=='') {
        //     $reportereserva = Reportereserva::where('reportereserva.estado','=','1')
        //     ->join('salas','reportereserva.idSala','=','salas.id')
        //     ->join('reserva','reportereserva.idSala','=','reserva.id')
        //     ->select('reserva.id','salas.nombre as idSala','reportereserva.idReservaNombre as idReservaNombre',
        //             'reportereserva.idFecha as idFecha','reportereserva.idObservaciones as idObservaciones','reporteserva.estado')
        //     ->orderBy('reportereserva.id','desc')
        //     ->paginate(5);
        // }
        // else {
        //     $reportereserva = Reportereserva::where('reportereserva.estado','=','1')
        //     ->where($criterio, 'like', '%'. $buscar . '%')
        //     ->orderBy('reportereserva.id','desc')
        //     ->paginate(5);
        // }

        // return [
        //     'pagination' => [
        //         'total'         =>$reportereserva->total(),
        //         'current_page'  =>$reportereserva->currentPage(),
        //         'per_page'      =>$reportereserva->perPage(),
        //         'last_page'     =>$reportereserva->lastPage(),
        //         'from'          =>$reportereserva->firstItem(),
        //         'to'            =>$reportereserva->lastItem(),
        //     ],
        //         'reportereserva' => $reportereserva,
        // ];
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $reserva = Reserva::where('reserva.estado','=','1')
            ->join('salas','reserva.idSala','=','salas.id')
            ->select('reserva.id','salas.nombre as idSala','reserva.reservaNombre',
                    'reserva.fecha','reserva.observaciones','reserva.estado')
            ->orderBy('reserva.id','desc')
            ->paginate(5);
        }
        else {
            $reserva = Reserva::where('reserva.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('reserva.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$reserva->total(),
                'current_page'  =>$reserva->currentPage(),
                'per_page'      =>$reserva->perPage(),
                'last_page'     =>$reserva->lastPage(),
                'from'          =>$reserva->firstItem(),
                'to'            =>$reserva->lastItem(),
            ],
                'reserva' => $reserva,
        ];
    }

    public function listado(){

        // $reportereserva = Reportereserva::where('reportereserva.estado','=','1')
        // ->orderBy('reportereserva.id','desc')
        // ->get();

        // return ['reportereserva' => $reportereserva];
        $reserva = Reserva::where('reserva.estado','=','1')
        ->orderBy('reserva.id','desc')
        ->get();

        return ['reserva' => $reserva];
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

    ///funcion de filtrar fecha

    public function filtrar(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $fecha1= $request->fecha1;
        $fecha2= $request->fecha2;

        if ($fecha2>$fecha1) {
            $reportereserva = Reportereserva::join('salas','reportereserva.idSala','=','salas.id')
            ->join('reserva','reportereserva.idSala','=','reserva.id')
            ->select('reserva.id','reserva.fecha','reserva.nombre as Sala',
                    'salas.descripcion','reserva.reservaNombre','reserva.observaciones')
            ->where('reserva.fecha','>=',$fecha1)
            ->orWhere('reserva.fecha','<',$fecha2)
            ->orderBy('reserva.id','desc')
            ->paginate(5);
        }
        else {
            // $reserva = reserva::where('reserva.estado','=','1')
            // ->where('reserva.fecha','>=',$fecha1)
            // ->orWhere('reserva.fecha','<',$fecha2)
            // ->orderBy('reserva.id','desc')
            // ->paginate(5);
            return "la estas cagando con las fechas";
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
    
}
