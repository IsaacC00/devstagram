<?php

//todo en este controlador debe estar protegido 

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    //el usuario debe estar logeado para tener acceso a tdas la funcionalidades
    public function __construct() {
        $this->middleware('auth')->except('show','index');
    }

    public function index(User $user)
    {       //Auth() es un helper que revisa que usuario esta autenticado actualmente
        //filtrar todos los post del usuario autenticadp
        $posts=Post::where('user_id',$user->id)->latest()->paginate(4);
        // solo hemos creado la consulta para traer los psot de cada uusario
        // acontinuacion debemos mostralos en el dashboard
        //aqui
        return view('layouts.dashboard',[
            'user' => $user,
            'posts'=>$posts
        ]);
    }

    //creamos el view 
    public function create()
    {
        //           accedemos a la carpeta, . para acceder a la carpeta, y el nombre del archivo 
        return view('posts.create');
    }

    // validamos y guardamos el post 
    public function store(Request $request)
    {
        $this->validate($request,[
            'titulo'=>'required|max:255',
            'descripcion'=>'required',
            'imagen' => 'required'
        ]);
        /***
        Post::create([
            'titulo'=>$request->titulo,
            'descripcion'=>$request->descripcion,
            'imagen'=>$request->imagen,
            'user_id'=>auth()->user()->id
            
        ]);
        */
        //otra forma de crear regsitros 
        /*** 
        $post = new Post();
        $post->titulo->request->titulo;
        $post->descripcion->request->descripcion;
        $post->imagen->request->imagen;
        $post->user_id->auth()->user()->id;
        $post->save();
        */
        
        //la foram de laravel para crear un post 

        $request->user()->posts()->create([
            'titulo'=>$request->titulo,
            'descripcion'=>$request->descripcion,
            'imagen'=>$request->imagen,
            'user_id'=>auth()->user()->id
        ]);
        
        return redirect()->route('post.index',auth()->user()->username);

    }

    public function show(User $user, Post $post)
    {
        return view('posts.show',[
            'post'=>$post,
            'user'=>$user
        ]);
    }
    
    public function destroy(Post $post)
    {
        //para no escribir tipico codigo php
        //pra validar que el usuario sea el correcto
        //podemos realizar una policy
        //php artisan make:policy PostPolicy --model=Post
        /*
        if ($post->user_id===auth()->user()->id) {
            dd(' usted si es '.$post->user->username);
        }else{
            dd('no es la misma persona');
        }*/
        //mejor asi
        $this->authorize('delete',$post);
        $post->delete();
        
        //codigo para borrar las imagenes
        //de las carpetas ddonde se alamacena las imagenes 
        //sin embargo existe un problema 
        //cuando eliminamos las publicaciones 
        //los coemntarios de las publicaciones
        //no se borrarn para elllo debemos 
        //agregar un cosntrain en la base de datos 
        //y ademas debemos poner una eliminacion en cascada 
        //para que todos los coemntarios de kas 
        //publiccaiones se eliminen y no dejen 
        //hiellas en las publicaciones 
        //especialmente en kla base de datos 
        
        $imagen_path=public_path('uploads/'.$post->imagen);

        if (File::exists($imagen_path)) {
            unlink($imagen_path);
        }
        
        return redirect()->route('post.index', auth()->user()->username);
    }
    
}
