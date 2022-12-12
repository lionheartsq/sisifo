<?php

namespace App\Http\Controllers;

use App\Reserva;
use App\Reportereserva;
use App\Horas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    //funcion para traer datos básicos de los reserva
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
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

        $reserva = Reserva::where('reserva.estado','=','1')
        ->orderBy('reserva.id','desc')
        ->get();

        return ['reserva' => $reserva];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Reserva=new Reserva();
        $Reserva->idSala=$request->idSala;
        $Reserva->reservaNombre=$request->reservaNombre;
        $Reserva->fecha=$request->fecha;
        $Reserva->observaciones=$request->observaciones;
        $Reserva->estado=1;
        $Reserva->save();

    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Reserva=Reserva::findOrFail($request->id);
        $Reserva->idSala=$request->idSala;
        $Reserva->reservaNombre=$request->reservaNombre;
        $Reserva->fecha=$request->fecha;
        $Reserva->observaciones=$request->observaciones;
        $Reserva->estado=1;
        $Reserva->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Reserva=Reserva::findOrFail($request->id);
        $Reserva->estado='2';
        $Reserva->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Reserva=Reserva::findOrFail($request->id);
        $Reserva->estado='1';
        $Reserva->save();
    }

    public function filtroFecha(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $fechainicio= $request->fechainicio;
        $fechafin= $request->fechafin;

        // if ($fechainicio<$fechafin) {
            $reserva = Reserva::whereBetween('reserva.fecha',[$fechainicio,$fechafin])
            ->where('reserva.estado','=','1')
            ->join('salas','reserva.idSala','=','salas.id')
            ->select('reserva.id','salas.nombre as idSala','reserva.reservaNombre',
                    'reserva.fecha','reserva.observaciones','reserva.estado')
            ->orderBy('reserva.id','desc')
            ->get();
        
            return [
                
                    'reserva' => $reserva,
            ];
    
            }

            public function hora(){
                $horas = Horas::orderBy('id','asc')->get();
                return ['horas' => $horas];
            }
    }
