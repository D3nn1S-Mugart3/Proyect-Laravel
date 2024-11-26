<?php

namespace App\Livewire;

use App\Models\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImagenesComponent extends Component
{
    use WithFileUploads;

    public $imagenes, $nombre, $descripcion, $imagen, $imagenId;
    public $isEditMode = false;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    public function render()
    {
        $this->imagenes = Image::all();
        return view('livewire.imagenes-component');
    }

    public function store()
    {
        $this->validate();

        $rutaImagen = $this->imagen ? $this->imagen->store('imagenes', 'public') : null;

        Image::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'imagen' => $rutaImagen,
        ]);

        $this->resetForm();
        session()->flash('message', 'Imagen creada exitosamente.');
    }

    public function edit($id)
    {
        $imagen = Image::findOrFail($id);
        $this->imagenId = $imagen->id;
        $this->nombre = $imagen->nombre;
        $this->descripcion = $imagen->descripcion;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();

        $imagen = Image::findOrFail($this->imagenId);

        if ($this->imagen) {
            // Borrar la imagen anterior si existe
            if ($imagen->imagen && file_exists(public_path('storage/' . $imagen->imagen))) {
                unlink(public_path('storage/' . $imagen->imagen));
            }

            $imagen->imagen = $this->imagen->store('imagenes', 'public');
        }

        $imagen->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
        ]);

        $this->resetForm();
        session()->flash('message', 'Imagen actualizada exitosamente.');
    }

    public function delete($id)
    {
        $imagen = Image::findOrFail($id);

        if ($imagen->imagen && file_exists(public_path('storage/' . $imagen->imagen))) {
            unlink(public_path('storage/' . $imagen->imagen));
        }

        $imagen->delete();

        session()->flash('message', 'Imagen eliminada exitosamente.');
    }

    public function resetForm()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->imagen = null;
        $this->imagenId = null;
        $this->isEditMode = false;
    }
}
