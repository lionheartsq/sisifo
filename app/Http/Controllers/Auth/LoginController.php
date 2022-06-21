<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }

    public function username()
    {
        return 'email';
    }

    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required|string',
            'password'=>'required|string'
        ]);

        Log::info('Showing user profile for user: '.$request);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'estado'=>'1'])){
            return redirect()->route('principal');
        }
        else{
            return back()->withErrors(['email'=>trans('auth.failed')])
            ->withInput(request(['email']));
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login');
    }

    public function pass(Request $request){
        $id=$request->idusuarios;
        $clave=$request->passnueva;

        $clavehashed = Hash::make($clave, [
            'rounds' => 12,
        ]);

        $affected = DB::table('users')
              ->where('idusuarios', $id)
              ->update(['password' => $clavehashed]);
              Auth::logout();
              $request->session()->invalidate();
        return redirect('/login');
    }

}
