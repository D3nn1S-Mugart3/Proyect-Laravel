<?php

use App\Http\Controllers\ImageController;
use App\Livewire\Imagenes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/imagenes', [ImageController::class, 'getAllImagen']);
Route::get('/imagenes/{id}', [ImageController::class, 'getByIdImagen']);
Route::post('/imagenes', [ImageController::class, 'postImagen']);
Route::post('/imagenes/{id}', [ImageController::class, 'postActualizarImagen']);
Route::delete('/imagenes/{id}', [ImageController::class, 'deleteImagen']);

Route::get('/api-imagenes', [App\Livewire\Imagenes::class, 'index'])->name('imagenes-component');
