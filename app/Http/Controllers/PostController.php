<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }

    public function index(User $user)
    {        
        $posts = Post::where('user_id', $user->id)->paginate(10);
        // dd($posts);
        return view('dashboard', [
            'user'=>$user,
            'posts'=>$posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {        
        $this->validate($request,[
            'titulo'=>'required|max:255',
            'descripcion'=>'required',
            'imagen'=>'required'
        ]);

        //Crear registros en la base de datos
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);


        //Otra forma de crear registros en la base de datos
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        //Otra forma de crear registros usando una relacion de un modelo, 
        //en este caso usando el modelo de User con la relacion OneToMany (1 usuario Muchos posts)
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);


        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post){

        // Verificar que el $user en la url sea el dueño de $post a mostrar.
        if($user->id != $post->user_id) {
            return redirect()->route('posts.index', auth()->user()->username);
        }

        return view('posts.show', [
            'post'=>$post, 
            'user'=>$user
        ]);
    }

    public function destroy(Post $post){        
        //CREAR UN POLICY
        //Para verificar que el post pertenezca al usuario logueado
        //php artisan make:policy PostPolicy --model=Post

        $this->authorize('delete', $post);
        $post->delete();

        //Eliminar la imagen
        $imagen_path = public_path('uploads/'.$post->imagen);
        if (File::exists($imagen_path)) {
            unlink($imagen_path);
        }

        return redirect()->route('posts.index', auth()->user()->username);

    }
}
