<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageExportController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/export-pdf', [ImageExportController::class, 'exportPDF'])->name('export.pdf');
// Route::get('/imagenes', [ImageController::class, 'getAllImagen'])->name('imagenes.index');
// Route::get('/imagenes/create', [ImageController::class, 'create'])->name('imagenes.create'); // Ruta para el formulario de creación
// Route::post('/imagenes', [ImageController::class, 'postImagen'])->name('imagenes.store');
// Route::get('/imagenes/{id}', [ImageController::class, 'getByIdImagen'])->name('imagenes.show');
// Route::put('/imagenes/{id}', [ImageController::class, 'putImagen'])->name('imagenes.update');
// Route::delete('/imagenes/{id}', [ImageController::class, 'deleteImagen'])->name('imagenes.destroy');
// Route::get('/imagenes', [ImageController::class, 'index'])->name('imagenes.index');
