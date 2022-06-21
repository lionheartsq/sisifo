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
            $usuarios = User::join("roles","usuarios.idroles","=","roles.idroles")
                ->select('usuarios.idusuarios','usuarios.documento','roles.rol',
                'usuarios.estado as estado','usuarios.telefono as telefono','usuarios.email as email',
                DB::raw('UPPER (concat(usuarios.nombres," ",usuarios.apellidos)) as acudiente')
                )
                ->whereIn('usuarios.estado', ['A'])
                ->whereNotIn('usuarios.idroles', ['5'])
                ->whereNotIn('usuarios.documento', ['13514998'])
                ->orderBy('usuarios.idusuarios','desc')
                ->paginate(5);
        }
        else {
            $usuarios = User::join("roles","usuarios.idroles","=","roles.idroles")
            ->select('usuarios.idusuarios','usuarios.documento','roles.rol',
            'usuarios.estado as estado','usuarios.telefono as telefono','usuarios.email as email',
            DB::raw('UPPER (concat(usuarios.nombres," ",usuarios.apellidos)) as acudiente')
            )
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->whereNotIn('usuarios.idroles', ['5'])
            ->whereNotIn('usuarios.documento', ['13514998'])
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
}
