<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\registerContreller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',HomeController::class)->name('home');
//creacion de nuestro controllador
// un contrlador basicamente es el medidador que permite que cuando un usuario, entre a un url 
// el controlador llamara una vista y a un modelo en caso de serlo asi 
// el modelo permite realizar el crud de la base de datos pero no muestra los datos
// la vista es la que se encarga de realizar todo ello 
Route::get('/register', [registerContreller::class ,'index'])->name('register');
Route::post('/register', [registerContreller::class ,'store']); 

//controlador en caso de que el usuario no este  autenticado

Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'store']);
//sustituimos el metodo get por el metodo post para seguridad de servidorea
Route::post('/logout',[LogoutController::class,'store'])->name('logout');

//rutas para editar perfil 
Route::get('/editar-perfil',[PerfilController::class,'index'])->name('perfil.index');
Route::post('/editar-perfil',[PerfilController::class,'store'])->name('perfil.store');

// al momento de poner {} estamoes creando una variable
// ROUTE MODEL BINDING
Route::get('/{user:username}',[PostController::class,'index'])->name('post.index');

//mostrat el view para crrear un post 
Route::get('/posts/create',[PostController::class,'create'])->name('posts.create');

//end point para validar y guardar los post  
Route::post('/posts',[PostController::class,'store'])->name('posts.store');

//raoute para poder ver las publicaciones en pantalla completa
Route::get('/{user:username}/posts/{post}',[PostController::class,'show'])->name('post.show');
//route para eliminar un post 
Route::delete('/posts/{post}',[PostController::class,'destroy'])->name('posts.destroy');

//route para guardar comentario 
Route::post('/{user:username}/posts/{post}',[ComentarioController::class,'store'])->name('comentario.store');

// verificar la redirecion del sistema... la comunicacion de 
// todos mismos estamos asi.... 
Route::post( '/imagenes' ,[ImagenController::class,'store'])->name('imagenes.store');
//likes de usuario 
Route::post('/posts/{post}/likes',[LikeController::class,'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes',[LikeController::class,'destroy'])->name('posts.likes.destroy');

//Siguiendo a los usuarios
Route::post('/{user:username}/follow',[FollowerController::class,'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow',[FollowerController::class,'destroy'])->name('users.unfollow');
