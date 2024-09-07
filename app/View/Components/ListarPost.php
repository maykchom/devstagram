<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListarPost extends Component
{

    public $posts;

    //Se recibe $posts de home.blade.php en el constructor de esta clase para que automáticamente se envíe a listar-post.blade.php y se pueda usar en ese componente
    public function __construct($posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.listar-post');
    }
}
