<?php

namespace App\Http\Controllers;

use App\Tb_area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Tb_areaController extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        // Cambios multiempresa
        $user = Auth::user();
        $empresa = $user->empresas->first();  // Obtiene la primera empresa de la relación

        if ($empresa) {
            $idEmpresa = $empresa->id;  // Accede a la propiedad "id" del objeto
            // Realizar operaciones con $idEmpresa
        }
        //cambios multiempresa

        if ($buscar=='') {
            $areas = Tb_area::where('areas.estado','=','1')
            ->orderBy('areas.id','desc')
            //->where('tb_area.idEmpresa','=',$idEmpresa)
            ->paginate(5);
        }
        else {
            $areas = Tb_area::where('areas.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            //->where('tb_area.idEmpresa','=',$idEmpresa)
            ->orderBy('areas.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$areas->total(),
                'current_page'  =>$areas->currentPage(),
                'per_page'      =>$areas->perPage(),
                'last_page'     =>$areas->lastPage(),
                'from'          =>$areas->firstItem(),
                'to'            =>$areas->lastItem(),
            ],
                'areas' => $areas
        ];
    }

    public function selectArea(){

        // Cambios multiempresa
        $user = Auth::user();
        $empresa = $user->empresas->first();  // Obtiene la primera empresa de la relación

        if ($empresa) {
            $idEmpresa = $empresa->id;  // Accede a la propiedad "id" del objeto
            // Realizar operaciones con $idEmpresa
        }
        //cambios multiempresa

        $areas = Tb_area::where('estado','=','1')
        ->where('tb_area.idEmpresa','=',$idEmpresa)
        ->select('id as idArea','area')
        ->orderBy('area','asc')->get();

        return ['areas' => $areas];
    }

    public function store(Request $request)
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
        $tb_area=new Tb_area();
        $tb_area->area=$request->area;
        $tb_area->idEmpresa=$idEmpresa;
        $tb_area->save();
    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $tb_area=Tb_area::findOrFail($request->id);
        $tb_area->area=$request->area;
        $tb_area->idEmpresa=$idEmpresa;
        $tb_area->save();
    }

    public function deactivate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_area=Tb_area::findOrFail($request->id);
        $tb_area->estado='2';
        $tb_area->save();
    }

    public function activate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_area=Tb_area::findOrFail($request->id);
        $tb_area->estado='1';
        $tb_area->save();
    }
}
