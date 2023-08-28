<?php

namespace App\Http\Controllers;

use App\Tb_proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Tb_proveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $proveedores = Tb_proveedor::where('idEmpresa','=',$idEmpresa)
            ->orderBy('id','desc')->paginate(5);
        }
        else {
            $proveedores = Tb_proveedor::where('idEmpresa','=',$idEmpresa)
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$proveedores->total(),
                'current_page'  =>$proveedores->currentPage(),
                'per_page'      =>$proveedores->perPage(),
                'last_page'     =>$proveedores->lastPage(),
                'from'          =>$proveedores->firstItem(),
                'to'            =>$proveedores->lastItem(),
            ],
                'proveedores' => $proveedores
        ];
    }

    public function selectProveedor(){

        // Cambios multiempresa
        $user = Auth::user();
        $empresa = $user->empresas->first();  // Obtiene la primera empresa de la relación

        if ($empresa) {
            $idEmpresa = $empresa->id;  // Accede a la propiedad "id" del objeto
            // Realizar operaciones con $idEmpresa
        }
        //cambios multiempresa

        $proveedores = Tb_proveedor::where('idEmpresa','=',$idEmpresa)
        ->where('estado','=','1')
        ->select('id as idProveedor','razonSocial')->orderBy('id','asc')->get();

        return ['proveedores' => $proveedores];
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

        if(!$request->ajax()) return redirect('/');
        $tb_proveedor = new Tb_proveedor();
        $tb_proveedor->nit=$request->nit;
        $tb_proveedor->razonSocial=$request->razonSocial;
        $tb_proveedor->contacto=$request->contacto;
        $tb_proveedor->telefono=$request->telefono;
        $tb_proveedor->direccion=$request->direccion;
        $tb_proveedor->correo=$request->correo;
        $tb_proveedor->idEmpresa=$idEmpresa;
        $tb_proveedor->save();
    }

    public function update(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $tb_proveedor = Tb_proveedor::findOrFail($request->id);
        $tb_proveedor->nit=$request->nit;
        $tb_proveedor->razonSocial=$request->razonSocial;
        $tb_proveedor->contacto=$request->contacto;
        $tb_proveedor->telefono=$request->telefono;
        $tb_proveedor->direccion=$request->direccion;
        $tb_proveedor->correo=$request->correo;
        $tb_proveedor->estado='1';
        $tb_proveedor->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_proveedor=Tb_proveedor::findOrFail($request->id);
        $tb_proveedor->estado='2';
        $tb_proveedor->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_proveedor=Tb_proveedor::findOrFail($request->id);
        $tb_proveedor->estado='1';
        $tb_proveedor->save();
    }
}
