<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //Datos que tendrá la tabla y se llenarán
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];


    //Relacion
    //1 a 1 (1 post pertence a 1 usuario)
    //El select sirve para seleccionar los datos que necesitamos tener
    //Para consultar con tinker es:
    //$post = Post::find(1);
    //$post->user
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    //Relacion
    //1 a muchos (1 post tiene muchos comentario)
    public function comentarios(){
        return $this->hasMany(Comentario::class);
    }

    //Relacion
    //1 post tienen muchos likes
    public function likes(){
        return $this->hasMany(Like::class);
    }

    //Revisar si un usuario ya le dio like a una publicacion
    public function checkLike(User $user){
        return $this->likes->contains('user_id', $user->id);
    }
}
