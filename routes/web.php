<?php

use App\Http\Controllers\PDFController;
use App\Http\Controllers\RegistrarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [RegistrarController::class, 'registrarUsuario']);
Route::get('/pdf', [PDFController::class, 'generadorPDF'])->name('Archivo.PDF');
