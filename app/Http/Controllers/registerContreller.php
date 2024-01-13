<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
//facades son funcioens que de ayudan en laravle para hacer funciones
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class registerContreller extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }
    
    public function store(Request $request){

        //modificacion para username no sea repetido
        $request->request->add(['username'=>Str::slug($request->username)]);
        
        //dd($reques);
        //accso de manera individual a los valores que recibo por post
        //dd($reques->get('username'));
        //Validacion
        $this->validate($request,[
            //cada uno de estos valores vienen de la etiqueta "name" del formulario
            'name'=>['required','max:30'],
            'username'=>['required','unique:users','min:3','max:20'],
            'email'=>['required','unique:users','email','max:60'],
            'password'=>['required','confirmed','min:6']
            
        ]); 
        
        //dd($request->get('username'));
        //inser into
        User::create([
            'name'=> $request->name,
            'username'=>$request->username,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);
        
        //autenticar usuario 
        //auth()->attempt([
        //    'email'=>$request->email,
        //    'password'=>$request->password,
        //
        //]); 
        auth()->attempt($request->only('email','password'));
        
        //redirecionamos al usuario a su muro
        return redirect()->route('post.index',auth()->user()->username);

    }

}
