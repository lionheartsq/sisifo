<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Control;
use App\Empleados;
use App\Historico;
use SebastianBergmann\Environment\Console;

class ControlController extends Controller
{
    //
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

        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $control = Control::orderBy('control.id','desc')
            ->paginate(5);
        }
        else {
            $control = Control::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('control.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$control->total(),
                'current_page'  =>$control->currentPage(),
                'per_page'      =>$control->perPage(),
                'last_page'     =>$control->lastPage(),
                'from'          =>$control->firstItem(),
                'to'            =>$control->lastItem(),
            ],
                'control' => $control,
        ];
    }

    public function listado(){
        $control = Control::where('control.estado','=','1')
        ->orderBy('control.id','desc')
        ->get();

        return ['control' => $control];
    }

    public function store(Request $request){
        if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $control=new Control();
        $control->idEmpleado=$request->idEmpleado;
        $control->idEmpresa=$idEmpresa;
        $control->estado='1';
        $control->save();

    }

    public function update(Request $request){
        if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $control=Control::findOrFail($request->id);
        $control->idEmpleado=$request->idEmpleado;
        $control->ingreso=$request->ingreso;
        $control->salida=$request->salida;
        $control->idEmpresa=$idEmpresa;
        $control->estado='1';
        $control->save();
    }

    public function deactivate(Request $request){
        if(!$request->ajax()) return redirect('/');
        $control=Control::findOrFail($request->id);
        $control->estado='0';
        $control->save();

    }

    public function activate(Request $request){
        if(!$request->ajax()) return redirect('/');
        $control=Control::findOrFail($request->id);
        $control->estado='1';
        $control->save();
    }

    public function selectControl(){
        $control = Control::where('estado','=','1')
        ->select('id as idEmpleado','control')->orderBy('control','asc')->get();

        return ['control' => $control];
    }
}
