<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Storage;

class EditPost extends Component
{
    use WithFileUploads;

    public $post;
    public $open = false;
    public $image, $identificador;

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    public function save(){
        $this->validate();

        if($this->image){
            Storage::delete([$this->post->image]);
            $this->post->image = $this->image->store('posts'); // ACTUALIZANDO NUEVA IMAGEN
        }

        $this->post->save();

        $this->reset(['open', 'image']);
        $this->identificador = rand();
        $this->emitTo('show-posts','render');
        $this->emit('alert', 'El post se actualizó exitosamente!');
    }

    public function mount(Post $post){
        $this->post = $post;
        $this->identificador = rand();
    }

    public function render()
    {
        return view('livewire.edit-post');
    }
}
