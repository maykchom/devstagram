<?php

namespace App\Models;

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
    ];

    //Relaciones
    //OneToMany (1 usario Muchos posts)
    public function posts() 
    {
        return $this->hasMany(Post::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    
    //Almacenar los seguidores de un usuario
    public function followers(){
        
        //El método de followers Pertence a muchos usuarios
        //Acá se especifica la tabla de donde se tendra la relacion en este caso 'Followers' con los campos 'user_id' y 'follower_id' con la tabla 'Users' con el campo 'user_id'
        //Es decir, tanto 'user_id' y 'follower_id' de la tabla followers tendran un 'user_id' de la tabla 'User'
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    //Almacenar los que seguimos
    public function followings(){        
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    //Comprobar si un usuario ya sigue a otro
    public function siguiendo (User $user){
        return $this->followers->contains($user->id);
    }



}
