<?php

namespace App\Http\Controllers;

use App\Departamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartamentosController extends Controller
{
    //funcion para traer datos básicos de los departamentos
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $departamentos = Departamentos::where('departamentos.estado','=','1')
            ->orderBy('departamentos.id','desc')
            ->paginate(5);
        }
        else {
            $departamentos = Departamentos::where('departamentos.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('departamentos.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$departamentos->total(),
                'current_page'  =>$departamentos->currentPage(),
                'per_page'      =>$departamentos->perPage(),
                'last_page'     =>$departamentos->lastPage(),
                'from'          =>$departamentos->firstItem(),
                'to'            =>$departamentos->lastItem(),
            ],
                'departamentos' => $departamentos,
        ];
    }

    public function listado(){

        $departamentos = Departamentos::where('departamentos.estado','=','1')
        ->orderBy('departamentos.id','desc')
        ->get();

        return ['departamentos' => $departamentos];
    }


}
