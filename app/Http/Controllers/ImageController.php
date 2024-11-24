<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ImageController extends Controller
{
    public function getByIdImagen($id)
    {
        $imagenes = Image::find($id);

        if (!$imagenes) {
            $data = ['message' => 'Dato no encontrado.', 'status' => 404];
            return response()->json($data, 404);
        }

        $imagenes->makeHidden(['created_at', 'updated_at']);

        return response()->json($imagenes, 200);
    }

    // Obtener todas las imágenes
    public function getAllImagen()
    {
        $imagenes = Image::all();

        if ($imagenes->isEmpty()) {
            return response()->json(['message' => 'No hay datos ingresados'], 404);
        }

        return response($imagenes, 200);
    }

    public function show()
    {
        $imagenes = Image::all(); // Obtén todos los registros de la tabla
        return view('images.index', compact('imagenes')); // Pasa los datos a la vista
    }

    public function postImagen(Request $request)
    {
        $validate = $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descripcion' => 'nullable|string',
        ]);

        $ruta_imagen = null;

        if ($request->hasFile('imagen')) {
            $ruta_imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        $imagenes = Image::create([
            'nombre' => $validate['nombre'],
            'imagen' => $ruta_imagen,
            'descripcion' => $validate['descripcion'] ?? null,
        ]);

        return response()->json(['message' => 'Datos creados exitosamente.', 'data' => $imagenes], 201);
    }

    public function putImagen(Request $request, $id)
    {
        $validate = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'imagen' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descripcion' => 'sometimes|nullable|string',
        ]);

        $imagen = Image::findOrFail($id);

        $ruta_imagen = $imagen->imagen;

        if ($request->hasFile('imagen')) {
            $ruta_imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        $imagen->update([
            'nombre' => $validate['nombre'] ?? $imagen->nombre,
            'imagen' => $ruta_imagen,
            'descripcion' => $validate['descripcion'] ?? $imagen->descripcion,
        ]);

        return response()->json(['message' => 'Datos actualizados exitosamente.', 'data' => $imagen->fresh()], 201);
    }

    public function deleteImagen($id)
    {
        $imagenes = Image::find($id);
        if (!$imagenes) {
            $data = ['message' => 'Dato no encontrado.', 'status' => 404];
            return response()->json($data, 404);
        }

        $imagenes->delete();

        $data = [
            'message' => 'El dato se ha eliminado correctamente.',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
