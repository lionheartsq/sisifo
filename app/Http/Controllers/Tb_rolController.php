<?php

namespace App\Http\Controllers;

use App\Roles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Tb_rolController extends Controller
{
    public function index(Request $request)
    {
        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $roles = Roles::orderBy('id','desc')->paginate(5);
        }
        else {
            $roles = Roles::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
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
                'roles' => $roles
        ];
    }

    public function selectRol(){
        $roles = Roles::where('estado','=','1')
        ->select('id as idRol','rol')->orderBy('rol','asc')->get();
        return ['roles' => $roles];
    }

    public function store(Request $request)
    {
        // Cambios multiempresa
        $idEmpresa =Auth::user()->idEmpresa;
        //cambios multiempresa

        if(!$request->ajax()) return redirect('/');
        $tb_rol=new Roles();
        $tb_rol->rol=$request->rol;
        $tb_rol->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_rol=Roles::findOrFail($request->id);
        $tb_rol->rol=$request->rol;
        $tb_rol->estado='1';
        $tb_rol->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_rol=Roles::findOrFail($request->id);
        $tb_rol->estado='2';
        $tb_rol->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_rol=Roles::findOrFail($request->id);
        $tb_rol->estado='1';
        $tb_rol->save();
    }
}
