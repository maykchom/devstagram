<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post;
    public $isLiked;
    public $likes;

    //EL MÉTODO mount() ES COMO UN CONSTRUCTOR DE ESTE COMPONENTE, SE EJECUTA AL INSTANCIAR ESTA CLASE (SE EJECUTA SOLO 1 VEZ)
    //LA VARIABLE $post VIENE DE <livewire:like-post :post="$post"/> EN show.blade.php Y ACÁ LO RECIBIMOS
    public function mount($post){
        //SE VERIFICA SI TIENE LIKE AL ENTRAR AL POST PARA PINTAR EL CORAZON DE ROJO O BLANCO
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like(){
        if ($this->post->checkLike(auth()->user())) {
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            //ACÁ ESTABLECEMOS SI TIENE LIKE DE ACUERDO A LA CONDICIÓN DE ARRIBA, ACÁ SE HACE ASÍ PORQUE LO QUE ESTA 
            //EN EL MÉTODO mount() SOLO SE EJECUTA UNA VEZ AL ENTRAR, PERO AL DAR EL EVENTO CLICK EN EL CORAZON 
            //SE TIENE QUE REEVALUAR (PARA VOLVER A PINTAR DE ROJO O BLANCO EL CORAZON) 
            //Y ESO YA NO LO HACE mount() YA QUE SOLO SE EJECUA UNA VEZ AL INICIAR EL COMPONENTE Y NO AL ACCIONAR EL EVENTO CLICK
            $this->isLiked = false;
            $this->likes--;
        }else{
            $this->post->likes()->create([
                'user_id' => auth()->user()->id,
                'post_id' => $this->post->id
            ]);
            //ACÁ ESTABLECEMOS SI TIENE LIKE DE ACUERDO A LA CONDICIÓN DE ARRIBA, ACÁ SE HACE ASÍ PORQUE LO QUE ESTA 
            //EN EL MÉTODO mount() SOLO SE EJECUTA UNA VEZ AL ENTRAR, PERO AL DAR EL EVENTO CLICK EN EL CORAZON 
            //SE TIENE QUE REEVALUAR (PARA VOLVER A PINTAR DE ROJO O BLANCO EL CORAZON) 
            //Y ESO YA NO LO HACE mount() YA QUE SOLO SE EJECUA UNA VEZ AL INICIAR EL COMPONENTE Y NO AL ACCIONAR EL EVENTO CLICK
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
