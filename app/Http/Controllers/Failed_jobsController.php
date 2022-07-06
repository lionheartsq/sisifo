<?php

namespace App\Http\Controllers;

use App\Failed_jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Failed_jobsController extends Controller
{
    //funcion para traer datos básicos de los failed_jobs
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $failed_jobs = Failed_jobs::where('failed_jobs.estado','=','1')
            ->orderBy('failed_jobs.id','desc')
            ->paginate(5);
        }
        else {
            $failed_jobs = Failed_jobs::where('failed_jobs.estado','=','1')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('failed_jobs.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$failed_jobs->total(),
                'current_page'  =>$failed_jobs->currentPage(),
                'per_page'      =>$failed_jobs->perPage(),
                'last_page'     =>$failed_jobs->lastPage(),
                'from'          =>$failed_jobs->firstItem(),
                'to'            =>$failed_jobs->lastItem(),
            ],
                'failed_jobs' => $failed_jobs,
        ];
    }

    public function listado(){

        $failed_jobs = Failed_jobs::where('failed_jobs.estado','=','1')
        ->orderBy('failed_jobs.id','desc')
        ->get();

        return ['failed_jobs' => $failed_jobs];
    }


}
