<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    public function user()
    {
        //relacion inversa de un post solo puede tener 
        // un usario
        return $this->belongsTo(User::class)->select(['name','username']);
    }

    public function comentarios()
    {
        //un post va a tener varios comentarios
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user)
    {
        //esta funcion lo que hace es que revisa 
        //la tabla likes(la anterior funcion),
        //y despues revisa la columna user_id
        //y compara con el user id de la variable
        return $this->likes->contains('user_id',$user->id);
    }
}
