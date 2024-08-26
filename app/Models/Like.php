<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable =[
        //Por el echo de que POST crea una relación con likes se sobre entiende que la tabla likes tendrá una 
        //llave foranea de POST y no es necesario escribirlo explicitamente (pero se puede colocar si se quisiese) acá en $fillable.
        //La linea que se sobre entiende y no se podria coloca es la siguiente:
        //'post_id'
        'user_id',
        'post_id'
    ];
}
