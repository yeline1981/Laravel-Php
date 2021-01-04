<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;

use App\Usuario;


class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){

        $this->validateLogin($request);

        if (Auth::attempt(['login' => $request->login,'password' => $request->password])){
           return redirect()->route('main');
           //return 'Tu sesion iniciada ok';
        }

        return back()
        ->withErrors(['login' => trans('auth.failed')])
        ->withInput(request(['login']));

    }

    protected function validateLogin(Request $request){
        $this->validate($request,[
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }


    public function username()
    {
        return 'login';
    }



}
