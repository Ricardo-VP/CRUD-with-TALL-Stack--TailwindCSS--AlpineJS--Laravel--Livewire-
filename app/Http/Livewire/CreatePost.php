<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{

    use WithFileUploads;

    public $open = false;

    public $title, $content, $image, $identificador;

    public function mount(){
        $this->identificador = rand();
    }

    protected $rules = [ //VALIDACIONES
        'title' => 'required',
        'content' => 'required',
        'image' => 'required|image|max:2048'
    ];

   /*public function updated($propertyName){
        $this->validateOnly($propertyName);
    }*/

    public function save(){

        $this->validate(); // LLAMANDO AL METODO DE VALIDACIONES

        $image = $this->image->store('posts');

        Post::create([ // CREANDO EL POST
            'title' => $this->title,
            'content' => $this->content,
            'image' => $image
        ]);

        $this->reset(['open', 'title', 'content', 'image']); // RESETEANDO EL FORM

        $this->identificador = rand();

        $this->emitTo('show-posts','render'); // EMITIENDO EL METODO RENDER PARA SHOW-POSTS
        $this->emit('alert', 'El post se creó exitosamente!');
    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
