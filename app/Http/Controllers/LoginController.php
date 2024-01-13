<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() 
    {
        return view('auth.login');  
    }

    // lavaraible request es la que nos da la seguridad 
    public function store(Request $request)
    {   

        $this->validate($request,[
            // ojo es en pasado ESE INGLES
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if (!auth()->attempt($request->only('email','password'), $request->remember )) {
            //con back regresamos a la pagina anterior, en este caso sera al formulario de login
            return back()->with('mensaje','Credenciales Incorrectas');
        }
            return redirect()->route('post.index',auth()->user()->username);
        
    }
}
