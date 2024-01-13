<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
//una funcion que tiene ele proposito de hacer algo 
// y que ese integra coin laravel 
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');

        //de esta manera nos aseguramos que nuestra imagenes tengan un id unico
        //y evitamos errores en nuestra base de datos al no tener imagenes con nombres
        //repetidos
        $nombreImagen = Str::uuid() . "." . $imagen->extension();


        $imagenServidor = Image::make($imagen);
        //hacemos que la imagen se ajsute a un formato de 1000x1000
        $imagenServidor->fit(1000,1000);

        //movemos la imagen hacia la carpeta upload en public
        $imagenPath = public_path('uploads').'/'.$nombreImagen;
        //guardamos la imagen en la carpeta
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen'=>$nombreImagen]);   
    }
}

