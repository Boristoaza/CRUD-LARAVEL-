<?php

use App\Http\Controllers\PDFController;
use App\Http\Controllers\RegistrarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/buscador', [RegistrarController::class, 'Buscador'])->name('buscador.trabajador');
Route::post('/agregar', [RegistrarController::class, 'AgregarTrabajador'])->name('agregar.trabajador');
Route::post('/eliminar', [RegistrarController::class, 'eliminarTrabjador'])->name('eliminar.trabajador');
Route::post('/editar', [RegistrarController::class, 'editarTrabajador'])->name('editar.trabajdor');
Route::post('/perfil', [RegistrarController::class, 'perfil'])->name('perfil.idol');
// esto trae la data desde la base de datos
Route::get('/data',[RegistrarController::class, 'dataIdols'])->name('data.idol');


// Route::get('/pdf', [PDFController::class, 'generadorPDF'])->name('Archivo.PDF');
