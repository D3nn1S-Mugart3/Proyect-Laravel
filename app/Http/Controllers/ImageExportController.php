<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ImageExportController extends Controller
{
    public function exportPDF()
    {
        $imagenes = Image::all(); // Obtén los datos que deseas exportar
        $pdf = Pdf::loadView('pdf.imagenes', compact('imagenes')); // Usa una vista para el contenido
        return $pdf->download('imagenes.pdf'); // Descarga el PDF
    }
}
