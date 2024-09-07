@extends('layouts.app')

@section('titulo')
    Página principal
@endsection

@section('contenido')

    {{-- COMPONENTE, SIEMPRE QUE ALGO INICIE CON <x-nombre> SERÁ UN COMPONENTE --}}
    {{-- SI SE LE PASA CONTENIDO VA CON ETIQUE DE CIERRE </x-nombre>, DE LO CONTRARIO VA ASI <x-nombre/> --}}
    {{-- EL PARÁMETRO DE :posts="$posts" es el que se recibe del controlador HomeController y se envía a la clase ListarPost.php --}}
    <x-listar-post :posts="$posts"/>

    {{-- ALTERNATIVA A PONER UN IF Y LUEGO UN FORAECH --}}
    {{-- @forelse ($posts as $post)
        <h1>{{$post->titulo}}</h1>
    @empty
        <a href="">No hay posts</a>
    @endforelse --}}
@endsection