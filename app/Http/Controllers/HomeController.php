<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{   

    public function __construct()
    {
        return $this->middleware('auth');
    }
    //funcion que actua como constructor 
    //se ejecuta primero cada vez que es llamado 
    public function __invoke()
    {
        //obtener a las persona que seguimos 

            $ids=auth()->user()->following->pluck('id')->toArray();
            $posts = Post::whereIn('user_id',$ids)->latest()->paginate(20);
            return view('home',[
                'posts'=>$posts]);
    }
}
