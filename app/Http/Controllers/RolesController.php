<?php

namespace App\Http\Controllers;

use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    //funcion para traer datos básicos de los roles
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $roles = Roles::where('roles.estado','=','1')
            ->orderBy('roles.id','desc')
            ->paginate(5);
        }
        else {
            $roles = Roles::where('roles.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('roles.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$roles->total(),
                'current_page'  =>$roles->currentPage(),
                'per_page'      =>$roles->perPage(),
                'last_page'     =>$roles->lastPage(),
                'from'          =>$roles->firstItem(),
                'to'            =>$roles->lastItem(),
            ],
                'roles' => $roles,
        ];
    }

    public function listado(){

        $roles = Roles::where('roles.estado','=','1')
        ->orderBy('roles.id','desc')
        ->get();

        return ['roles' => $roles];
    }


}
