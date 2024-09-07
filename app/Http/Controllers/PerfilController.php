<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            //validamos el correo que sea requerido, tenga el formato de email, 60 caracteres como maximo, que sea único de la tabla usuarios a excepción si es el mismo correo.
            'email' => 'required|email|max:60|unique:users,email,'.auth()->user()->id
        ]);

        //validando solo cuando el correo sea diferente
        // if ($request->email != auth()->user()->email) {            
        //     $this->validate($request, [
        //     'email' => 'required|email|max:60|unique:users,email'
        //     ]);
        // }

        //Validar contraseñas
        //dd("CONTRASEÑA: ".$request->password." CONTRASEÑA NUEVA: ".$request->password_new);
        $this->validate($request, [
            'password' => 'nullable|string', // El campo1 es opcional y debe ser una cadena de texto si se proporciona.
            'password_new' => 'nullable|string|required_with:password', // El campo2 es opcional pero obligatorio si campo1 tiene texto.
        ],[
            'password_new.required_with' => 'Si colocaste contraseña actual, debes colocar tu nueva contraseña',
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
        $usuario->email = $request->email;
        //Se verifica si $nombreImagen tiene valor, si no, verifica si el usuario actual tiene imagen, de lo contrario se envia un string vacio
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;

        //Verificar contraseñas
        if ($request->password_new) {
            if (Hash::check($request->password, $usuario->password)) {
                $usuario->password = Hash::make($request->password_new);
                $usuario->save();
                return back()->with('cc', 'Datos actualizados exitosamente');
            }else{            
                $usuario->save();
                return back()->with('ci', 'Contraseña actual incorrecta, datos actualizados menos la contraseña');
            }            
        }else{
            $usuario->save();
            return back()->with('cc', 'Datos actualizados exitosamente');
        }


        //Redirecionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
