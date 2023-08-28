<?php

namespace App\Http\Controllers;

use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{
    //funcion para traer datos básicos de los roles
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
        ->orderBy('roles.rol','asc')
        ->get();

        return ['roles' => $roles];
    }

    public function store(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Roles=new Roles();
        $Roles->rol=$request->rol;
        $Roles->save();
    }

    public function update(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $idEmpresa=Auth::user()->idEmpresa;
        $Roles=Roles::findOrFail($request->id);
        $Roles->rol=$request->rol;
        $Roles->save();
    }

    public function deactivate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Roles=Roles::findOrFail($request->id);
        $Roles->estado='2';
        $Roles->save();
    }

    public function activate(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $Roles=Roles::findOrFail($request->id);
        $Roles->estado='1';
        $Roles->save();
    }
}
