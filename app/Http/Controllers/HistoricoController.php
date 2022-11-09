<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Control;
use App\Empleados;
use App\Historico;

class HistoricoController extends Controller
{
    //
    public function listarfecha(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
            $fecha1= $request->ingreso;
            $fecha2= $request->salida;

         
            $historico = Historico::join('control','historico.idEmpleado','=','control.id')
            ->select('historico.id','control.documento','control.nombres','control.apellidos',
            'historico.ingreso','historico.salida','historico.estado')
            ->where('historico.ingreso','>=',$fecha1)
            ->where('historico.salida','<=',$fecha2 )
            
            ->orderBy('historico.id','desc')
            ->get();

        return [
           
                'historico' => $historico,
        ];
    }

    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $historico = Historico::join('control','historico.idEmpleado','=','control.id')
            ->select('historico.id','control.documento','control.nombres','control.apellidos',
            'historico.ingreso','historico.salida','historico.estado')
            ->orderBy('historico.id','desc')
            ->paginate(5);
        }
        else {
            $historico = Historico::join('control','historico.idEmpleado','=','control.id')
            ->select('historico.id','control.documento','control.nombres','control.apellidos',
            'historico.ingreso','historico.salida','historico.estado')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('historico.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$historico->total(),
                'current_page'  =>$historico->currentPage(),
                'per_page'      =>$historico->perPage(),
                'last_page'     =>$historico->lastPage(),
                'from'          =>$historico->firstItem(),
                'to'            =>$historico->lastItem(),
            ],
                'historico' => $historico,
        ];
    }

    public function listado(){
        
        $historico = Historico::where('historico.estado','=','1')
        ->orderBy('historico.id','desc')
        ->get();

        return ['historico' => $historico];
    
    }

    public function store2(Request $request){
        // if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $historico=new Historico();
        $historico->idEmpleado=$request->idEmpleado;
        $historico->ingreso=$request->ingreso;
        $historico->salida=$request->salida;
        $historico->estado='0';
        $historico->save();

        $estado= $historico->estado;
        if(!$request->ajax()) return redirect('/');
        $control=Control::findOrFail($request->id);
        $control->estado=$estado;
        $control->save();
   
    }

    public function store(Request $request){
        // if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $historico=new Historico();
        $historico->idEmpleado=$request->idEmpleado;
        $historico->ingreso=$request->ingreso;
        $historico->salida= $request->salida;
        $historico->estado='1';
        $historico->save();


        $estado= $historico->estado;
        if(!$request->ajax()) return redirect('/');
        $control=Control::findOrFail($request->id);
        $control->estado=$estado;
        $control->save();
       
    }

    public function update(Request $request){
        if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $historico=Historico::findOrFail($request->id);
        $historico->documento=$request->documento;
        $historico->nombres=$request->nombres;
        $historico->apellidos=$request->apellidos;
        $historico->ingreso=$request->ingreso;
        $historico->salida=$request->salida;
        $historico->estado='1';
        $historico->save();
    }

    public function deactivate(Request $request){
        if(!$request->ajax()) return redirect('/');
        $historico=Historico::findOrFail($request->id);
        $historico->estado='0';
        $historico->save();
        
    }

    public function activate(Request $request){
        if(!$request->ajax()) return redirect('/');
        $historico=Historico::findOrFail($request->id);
        $historico->estado='1';
        $historico->save();

    }

    public function selectNombresApellidos($documento){
        
        $resultado=Empleados::select('empleados.nombres','empleados.apellidos')
        ->where('empleados.documento','=',$documento)
        ->get();

        foreach($resultado as $a){
            $nombres = $a->nombres;
            $apellidos = $a->apellidos;
        }

        return ['nombres' => $nombres,
                'apellidos' => $apellidos
                ];
    }
    public function selectHistorico(){
        $historico = Historico::where('estado','=','1')
        ->select('id as idEmpleado','historico')->orderBy('historico','asc')->get();

        return ['historico' => $historico];
    }

    public function mostrarHistorico(){ 
       
        $historico = Historico::join('control','historico.idEmpleado','=','control.id')
        ->select('historico.id','control.documento','control.nombres','control.apellidos',
        'historico.ingreso','historico.salida','historico.estado')
        ->orderBy('historico.id','asc')
        ->get();

        return ['historico' => $historico ];
    }
    public function mostrarIngresos(){
        $ingresos= Historico::join('control','historico.idEmpleado','=','control.id')
        ->select('historico.id','control.documento','control.nombres','control.apellidos',
        'historico.ingreso','historico.salida','historico.estado')
        ->where('historico.estado','=',1)
        ->orderBy('historico.id','asc')
        ->get();
        return ['ingresos' => $ingresos

        ];
    }

    public function mostrarSalidas(){
        $salidas= Historico::join('control','historico.idEmpleado','=','control.id')
        ->select('historico.id','control.documento','control.nombres','control.apellidos','historico.ingreso',
        'historico.salida','historico.estado')
        ->where('historico.estado','=',0)
        ->orderBy('historico.id','asc')
        ->get();
        return ['salidas' => $salidas

      ];
  }

}

