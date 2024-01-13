<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
         //modificacion para username no sea repetido
        $request->request->add(['username'=>Str::slug($request->username)]);
        
        $this->validate($request,[
        //recomendable la siguiente sintaxis 
        //laravel recomienda tener esta sintaxis para cuando se tiene mas de 3 parametros
                                                    //el usuario puede retomar su nombre
        'username'=>['required','unique:users,username,'.auth()->user()->id,'min:3','max:20'
        //no puede tener los siguietne nombres
        ,'not_in:twitter'],

        ]);

        if($request->imagen){

            $imagen = $request->file('imagen');

            //de esta manera nos aseguramos que nuestra imagenes tengan un id unico
            //y evitamos errores en nuestra base de datos al no tener imagenes con nombres
            //repetidos
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = Image::make($imagen);
            //hacemos que la imagen se ajsute a un formato de 1000x1000
            $imagenServidor->fit(1000,1000);
    
            //movemos la imagen hacia la carpeta upload en public
            $imagenPath = public_path('perfiles').'/'.$nombreImagen;
            //guardamos la imagen en la carpeta
            $imagenServidor->save($imagenPath);
    
        }
        //guardar cambios
        //buscar al usuario por id
        $usuario=User::find(auth()->user()->id);
        $usuario->username=$request->username;
        $usuario->imagen=$nombreImagen ?? auth()->user()->imagen ?? null;// revisar si ya tiene una imaagen no cambiar o podemos dejarlo vacio
        $usuario->save();
        //redireccionar
        return redirect()->route('post.index',$usuario->username);
    }
}
