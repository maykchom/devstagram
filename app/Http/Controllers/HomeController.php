<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Es como un constructor y sirve cuando una clase tiene solo un método
    //En vez de poner "index" colocamos __invoke porque será el único método de esta clase
    public function __invoke(){
        //pluck('id') nos devuelve solo ese campo de la consulta a la base de datos por medio de la relación establecida "followings"
        $ids=auth()->user()->followings->pluck('id')->toArray();
        // dd($ids);

        //Acá consultamos a la tabla Post si encuentra registros de su campo "user_id" iguales a los del arreglo "$ids" para que los filtre
        // $posts = Post::whereIn('user_id', $ids)->paginate(20);         
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);         

        // dd($posts->toArray());

        return view('home', [
            'posts' => $posts
        ]);
    }
}
