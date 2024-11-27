<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

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

        return response()->json([
            'id' => $imagenes->id,
            'nombre' => $imagenes->nombre,
            'imagen_url' => url('storage/' . $imagenes->imagen),
            'descripcion' => $imagenes->descripcion,
        ], 200);
    }

    // Obtener todas las imágenes
    public function getAllImagen()
    {
        $imagenes = Image::all();

        if ($imagenes->isEmpty()) {
            return response()->json(['message' => 'No hay datos ingresados'], 404);
        }

        // Transformar la colección a un formato adecuado
        $imagenesTransformadas = $imagenes->map(function ($imagen) {
            return [
                'id' => $imagen->id,
                'nombre' => $imagen->nombre,
                'imagen_url' => url('storage/' . $imagen->imagen),
                'descripcion' => $imagen->descripcion,
            ];
        });

        return response()->json($imagenesTransformadas, 200);
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

    public function postActualizarImagen(Request $request, $id)
    {
        $imagenes = Image::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|nullable|string|max:255',
            'imagen' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // La imagen es opcional
            'descripcion' => 'sometimes|nullable|string',
        ]);

        if ($request->has('nombre')) {
            $imagenes->nombre = $request->nombre;
        }

        if ($request->hasFile('imagen')) {
            if ($imagenes->imagen && file_exists(public_path('storage/' . $imagenes->imagen))) {
                unlink(public_path('storage/' . $imagenes->imagen));
            }

            $path = $request->file('imagen')->store('imagenes', 'public');

            $imagenes->imagen = $path;
        }

        if ($request->has('descripcion')) {
            $imagenes->descripcion = $request->descripcion;
        }

        $imagenes->save();

        return response()->json($imagenes, 201);
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
