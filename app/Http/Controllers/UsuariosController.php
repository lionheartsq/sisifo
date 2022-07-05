<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    //funcion para traer datos básicos de los usuarios
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $usuarios = User::join("roles","users.idRol","=","roles.id")
            ->join("empresa","users.idEmpresa","=","empresa.id")
            ->where('users.estado','=','1')
            ->select('users.id','users.documento','roles.rol','users.email as email','users.estado',
                DB::raw('UPPER (concat(users.nombres," ",users.apellidos)) as usuario'),
                'empresa.razonSocial','roles.id as idRol','empresa.id as idEmpresa')
            ->whereNotIn('users.id', ['1'])
            ->orderBy('users.id','desc')
            ->paginate(5);
        }
        else {
            $usuarios = User::join("roles","users.idRol","=","roles.id")
            ->join("empresa","users.idEmpresa","=","empresa.id")
            ->where('users.estado','=','1')
            ->select('users.id','users.documento','roles.rol','users.email as email','users.estado',
                DB::raw('UPPER (concat(users.nombres," ",users.apellidos)) as usuario'),
                'empresa.razonSocial','roles.id as idRol','empresa.id as idEmpresa')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->whereNotIn('usuarios.id', ['1'])
            ->orderBy('idusuarios','desc')
            ->paginate(5);
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
                'usuarios' => $usuarios,
        ];
    }

    public function listado(){

        $usuarios = User::join("roles","users.idRol","=","roles.id")
        ->join("empresa","users.idEmpresa","=","empresa.id")
        ->where('users.estado','=','1')
        ->select('users.id','users.documento','roles.rol','users.email as email','users.estado',
            DB::raw('UPPER (concat(users.nombres," ",users.apellidos)) as usuario'),
            'empresa.razonSocial','roles.id as idRol','empresa.id as idEmpresa')
        ->orderBy('users.id','asc')->get();

        return ['usuarios' => $usuarios];
    }


}
