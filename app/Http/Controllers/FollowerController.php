<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    //
    public function store(User $user)
    {
        //No se usa create, sino attach cuando existe una relacion de muchos a muchos o cuando hay varias relaciones con la misma tabla
        $user->followers()->attach(auth()->user()->id);
        return back();
    }

    public function destroy(User $user)
    {        
        $user->followers()->detach(auth()->user()->id);
        return back();
    }
}
