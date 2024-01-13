<?php

namespace App\Models;
// el unico modelo que viene por defecto en laravel ESTE
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts() 
    {   
        //relacion uno a muchos en laravel
        //se hace de la siguietne manera
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    //funcion para almacenar seguirdores de un usuario 
    //saliendo de las convenciones de laravel OJO
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers','user_id','follower_id');
    }

    //Comprobar si un usuario ya sigue a otro\
    public function siguiendo(User $user)
    {   
        //codigo para iterar en la tabla de followers y devolver true or false
        return $this->followers->contains($user->id);
    }

    //almacenar a los user que seguimos
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers','follower_id','user_id');
    }
}
