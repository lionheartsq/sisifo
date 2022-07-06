<?php

namespace App\Http\Controllers;

use App\Migrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MigrationsController extends Controller
{
    //funcion para traer datos básicos de los migrations
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $migrations = Migrations::where('migrations.estado','=','1')
            ->orderBy('migrations.id','desc')
            ->paginate(5);
        }
        else {
            $migrations = Migrations::where('migrations.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('migrations.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$migrations->total(),
                'current_page'  =>$migrations->currentPage(),
                'per_page'      =>$migrations->perPage(),
                'last_page'     =>$migrations->lastPage(),
                'from'          =>$migrations->firstItem(),
                'to'            =>$migrations->lastItem(),
            ],
                'migrations' => $migrations,
        ];
    }

    public function listado(){

        $migrations = Migrations::where('migrations.estado','=','1')
        ->orderBy('migrations.id','desc')
        ->get();

        return ['migrations' => $migrations];
    }


}
