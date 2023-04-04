<?php

use Illuminate\Support\Facades\Route;

// Home
use App\Http\Controllers\HomeController;

// Usuarios
// use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RecebedorController;

// Gastos
use App\Http\Controllers\GastoController;
use App\Http\Controllers\CategoriaGastoController;

// Entradas
use App\Http\Controllers\EntradaController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmprestarController;
use App\Http\Controllers\Relatorio_entradaController;
use App\Http\Controllers\RelatorioController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'Home'])->name('home');

    Route::resource('/recebedor', RecebedorController::class)->except('create', 'show');
    Route::resource('/categoria-gastos', CategoriaGastoController::class)->except('create', 'show');
    Route::resource('/gastos', GastoController::class)->except('create', 'show');
    Route::resource('/entradas', EntradaController::class)->except('create', 'show');
    Route::resource('/relatorios',RelatorioController::class)->except('create','show','edit');
    Route::resource('/emprestimo', EmprestarController::class)->except('create,show');
    // Route::resource('/relatorio_entrada', RelatorioController::class)->except('create','show','edit');
    Route::resource('/relatorio_entrada', Relatorio_entradaController::class)->except('create','show','edit');




    Route::get('/exportar',[RelatorioController::class, 'export']);



    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

