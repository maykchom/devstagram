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
    public function index(){
        return view('perfil.index');
    }

    public function store(Request $request){

        //Modificar el request para muestre el error en la vista de que ya existe el usario 
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20', 'not_in:twitter,editar-perfil'],
        ]);

        if ($request->imagen) {
            $imagen = $request->file('imagen');
            $nombreImagen= Str::uuid().".".$imagen->extension();
    
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000,1000);
    
            $imagenPath = public_path('perfiles').'/'.$nombreImagen;
            $imagenServidor->save($imagenPath);            
        }

        //Guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        //Se verifica si $nombreImagen tiene valor, si no, verifica si el usuario actual tiene imagen, de lo contrario se envia un string vacio
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        //Redirecionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
