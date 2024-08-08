<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @stack('styles')
        @vite('resources/js/app.js')
        <title>Devstagram - @yield('titulo')</title>
        @vite('resources/css/app.css')

    </head>
    <body class="bg-gray-100">
        <header class="p-5 border-b bg-white shadow">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-3xl font-black">Devstragram</h1>

                {{-- @if (auth()->user())
                    <p>Auntenticado</p>
                @else
                    <p>No autenticado</p>
                @endif --}}

                @auth
                    <p>Autenticado</p>
                    <nav class="flex gap-2 items-center">
                        <a href="{{route('posts.create')}}" class="flex items-center gap-2 bg-white border p-2 text-gray-600 rounded text-sm uppercase font-bold cursor-pointer">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 21H20C21.1046 21 22 20.1046 22 19V8.6C22 7.49543 21.1046 6.6 20 6.6L17 6.6L14.7983 3.4296C14.6115 3.16049 14.3046 3 13.977 3H10.023C9.6954 3 9.38855 3.16049 9.20166 3.4296L7 6.6L4 6.6C2.89543 6.6 2 7.49543 2 8.6V19C2 20.1046 2.89543 21 4 21Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16 13C16 15.2091 14.2091 17 12 17C9.79086 17 8 15.2091 8 13C8 10.7909 9.79086 9 12 9C14.2091 9 16 10.7909 16 13Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            Crear
                        </a>
                        <a class="font-bold  text-gray-600 text-sm" href="{{route('posts.index', auth()->user()->username)}}">Hola: <span class="font-normal">{{auth()->user()->username}}</span></a>
                        
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                            <button type="submit" class="font-bold  text-gray-600 text-sm">Cerrar sesión</button>
                        </form>

                    </nav>
                @endauth

                @guest
                    <p>No autenticado</p>
                    <nav class="flex gap-2 items-center">
                        <a class="font-bold uppercase text-gray-600 text-sm" href="{{route('login')}}">Login</a>
                        <a class="font-bold uppercase text-gray-600 text-sm" href="{{route('register')}}">Crear cuenta</a>
                    </nav>
                @endguest

            </div>
        </header>
        
        <main class="container mx-auto mt-10">
            <h2 class="font-black text-center text-3xl mb-10">@yield('titulo')</h2>
            @yield('contenido')
        </main>

        <footer class="mt-10 text-center p-5 text-gray-500 font-bold uppercase">
            DevStagram - Todos los derechos reservados {{now()->year}}
        </footer>
    </body>
    
</html>