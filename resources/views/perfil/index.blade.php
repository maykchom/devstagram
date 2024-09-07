@extends('layouts.app')

@section('titulo')
    Editar perfil: {{auth()->user()->username}}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            @if (session('cc'))
            <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                {{session('cc')}}
            </div>
            @endif
            @if (session('ci'))
            <div class="bg-yellow-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                {{session('ci')}}
            </div>
            @endif
            <form action="{{route('perfil.store')}}" method="POST" class="mt-10 md:mt-0" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">Nombre de usuario</label>
                    <input id="username" name="username" type="text" placeholder="Tu nombre de usuario" class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror" value="{{auth()->user()->username}}"/>
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">Email</label>
                    <input id="email" name="email" type="email" placeholder="Ingresa el nuevo email" class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror" value="{{auth()->user()->email}}"/>
                    @error('email')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Contraseña actual</label>
                    <input id="password" name="password" type="password" placeholder="Ingresa tu password" class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror"/>
                    @error('password')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
    
                <div class="mb-5">
                    <label for="password_new" class="mb-2 block uppercase text-gray-500 font-bold">Nueva contraseña</label>
                    <input id="password_new" name="password_new" type="password" placeholder="Ingresa tu nuevo password" class="border p-3 w-full rounded-lg"/>
                    @error('password_new')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2">{{$message}}</p>
                    @enderror
                </div>
    

                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">Imagen perfil</label>
                    <input id="imagen" name="imagen" type="file" class="border p-3 w-full rounded-lg" value="" accept=".jpg, .jpeg, .png"/>
                </div>
                <input type="submit" value="Guardar cambios" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection