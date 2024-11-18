<?php

namespace App\Http\Controllers;

use App\User;
use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        if ($buscar=='') {
            $usuarios = User::join('roles','users.idRol','=','roles.id')
            ->select('users.id','users.nombres','users.apellidos','users.documento','users.email','users.estado','roles.id as idRol','roles.rol')
            ->where('users.idEmpresa','=',$idEmpresa)
            ->orderBy('users.id','desc')->paginate(5);
        }
        else if($criterio=='nombres'){
            $usuarios = User::join('roles','users.idRol','=','roles.id')
            ->select('users.id','users.nombres','users.apellidos','users.documento','users.email','users.estado','roles.id as idRol','roles.rol')
            ->where('users.idEmpresa','=',$idEmpresa)
            ->where('users.nombres', 'like', '%'. $buscar . '%')
            ->orderBy('users.id','desc')->paginate(5);
        }
        else if($criterio=='rol'){
            $usuarios = User::join('roles','users.idRol','=','roles.id')
            ->select('users.id','users.nombres','users.apellidos','users.documento','users.email','users.estado','roles.id as idRol','roles.rol')
            ->where('users.idEmpresa','=',$idEmpresa)
            ->where('roles.rol', 'like', '%'. $buscar . '%')
            ->orderBy('users.id','desc')->paginate(5);
        }
        else if($criterio=='email'){
            $usuarios = User::join('roles','users.idRol','=','roles.id')
            ->select('users.id','users.nombres','users.apellidos','users.documento','users.email','users.estado','roles.id as idRol','roles.rol')
            ->where('users.idEmpresa','=',$idEmpresa)
            ->where('users.email', 'like', '%'. $buscar . '%')
            ->orderBy('users.id','desc')->paginate(5);
        }
        else if($criterio=='documento'){
            $usuarios = User::join('roles','users.idRol','=','roles.id')
            ->select('users.id','users.nombres','users.apellidos','users.documento','users.email','users.estado','roles.id as idRol','roles.rol')
            ->where('users.idEmpresa','=',$idEmpresa)
            ->where('users.documento', 'like', '%'. $buscar . '%')
            ->orderBy('users.id','desc')->paginate(5);
        }
        else {
            $usuarios = User::join('roles','users.idRol','=','roles.id')
            ->select('users.id','users.nombres','users.apellidos','users.documento','users.email','users.estado','roles.id as idRol','roles.rol')
            ->where('users.idEmpresa','=',$idEmpresa)
            ->where('users.id', 'like', '%'. $buscar . '%')
            ->orderBy('users.id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$usuarios->total(),
                'current_page'  =>$usuarios->currentPage(),
                'per_page'      =>$usuarios->perPage(),
                'last_page'     =>$usuarios->lastPage(),
                'from'          =>$usuarios->firstItem(),
                'to'            =>$usuarios->lastItem(),
            ],
                'usuarios' => $usuarios
        ];
    }

    public function store(Request $request)
    {
        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        if(!$request->ajax()) return redirect('/');

        $User=new User();
        $User->documento=$request->documento;
        $User->email=$request->email;
        $User->nombres=$request->nombres;
        $User->apellidos=$request->apellidos;
        $User->password=bcrypt($request->password);
        $User->idEmpresa=$idEmpresa;
        $User->idRol=$request->idRol;
        $User->estado='1';
        $User->save();

        $idtabla=DB::getPdo()->lastInsertId();

        $idEmpresa=Auth::user()->idEmpresa;

    }

    public function update(Request $request)
    {
        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        //if(!$request->ajax()) return redirect('/');
        $users=User::findOrFail($request->id);
        $users->documento=$request->documento;
        $users->email=$request->email;
        $users->nombres=$request->nombres;
        $users->apellidos=$request->apellidos;
        $users->password=bcrypt($request->password);
        $users->idEmpresa=$idEmpresa;
        $users->idRol=$request->idRol;
        $users->estado='1';
        $users->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $users=User::findOrFail($request->id);
        $users->estado='2';
        $users->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $users=User::findOrFail($request->id);
        $users->estado='1';
        $users->save();
    }

}
