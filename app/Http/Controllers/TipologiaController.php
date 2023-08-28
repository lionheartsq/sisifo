<?php

namespace App\Http\Controllers;

use App\Tipologia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TipologiaController extends Controller
{
    //funcion para traer datos básicos de los tipologia
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
            $tipologia = Tipologia::where('tipologia.estado','=','1')
            ->orderBy('tipologia.id','desc')
            ->paginate(5);
        }
        else {
            $tipologia = Tipologia::where('tipologia.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tipologia.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$tipologia->total(),
                'current_page'  =>$tipologia->currentPage(),
                'per_page'      =>$tipologia->perPage(),
                'last_page'     =>$tipologia->lastPage(),
                'from'          =>$tipologia->firstItem(),
                'to'            =>$tipologia->lastItem(),
            ],
                'tipologia' => $tipologia,
        ];
    }

    public function listado(){

        $tipologia = Tipologia::where('tipologia.estado','=','1')
        ->orderBy('tipologia.id','desc')
        ->get();

        return ['tipologia' => $tipologia];
    }


}
