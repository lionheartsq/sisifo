<?php

namespace App\Http\Controllers;

use App\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerController extends Controller
{
    //funcion para traer datos básicos de los controller
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $controller = Controller::where('controller.estado','=','1')
            ->orderBy('controller.id','desc')
            ->paginate(5);
        }
        else {
            $controller = Controller::where('controller.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('controller.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$controller->total(),
                'current_page'  =>$controller->currentPage(),
                'per_page'      =>$controller->perPage(),
                'last_page'     =>$controller->lastPage(),
                'from'          =>$controller->firstItem(),
                'to'            =>$controller->lastItem(),
            ],
                'controller' => $controller,
        ];
    }

    public function listado(){

        $controller = Controller::where('controller.estado','=','1')
        ->orderBy('controller.id','desc')
        ->get();

        return ['controller' => $controller];
    }


}
