<?php

namespace App\Livewire;

use App\Models\Image;
use Livewire\Component;

class Imagenes extends Component
{
    public function render()
    {
        return view('livewire.imagenes');
    }

    public function index()
    {
        $imagenes = Image::all();

        $data = [
            'imagenes' => $imagenes,
            'status' => 200,
        ];

        return response()->json([$data], 200);
    }
}
