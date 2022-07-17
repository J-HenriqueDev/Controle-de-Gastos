<?php

use Illuminate\Support\Facades\Route;


// Home
use App\Http\Controllers\HomeController;

// Usuarios
use App\Http\Controllers\UsuarioController;

// Gastos
use App\Http\Controllers\GastosController;
use App\Http\Controllers\CategoriaGastosController;

// Entradas
use App\Http\Controllers\EntradasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('home');
// })->middleware(['auth'])->name('home');

// Home
Route::get('/dashboard', [HomeController::class, 'Home'])->middleware(['auth'])->name('home');

// Usuario
Route::get('/usuario', [UsuarioController::class, 'Index'])->name('usuario.index');
Route::post('/usuario/store', [UsuarioController::class, 'Store'])->name('usuario.store');
Route::get('/usuario/{usuario_id}', [UsuarioController::class, 'Destroy'])->name('usuario.destroy');

// Categoria de Gastos
Route::get('/categoria/gastos', [CategoriaGastosController::class, 'Index'])->name('categoria.gastos.index');
Route::post('/categoria/gastos/store', [CategoriaGastosController::class, 'Store'])->name('categoria.gastos.store');
Route::get('/categoria/gastos/{categoria_id}', [CategoriaGastosController::class, 'Destroy'])->name('categoria.gastos.destroy');

// Gastos
Route::get('/gastos', [GastosController::class, 'Index'])->name('gastos.index');
Route::post('/gastos/store', [GastosController::class, 'Store'])->name('gastos.store');
Route::get('/gastos/{gasto_id}', [GastosController::class, 'Destroy'])->name('gastos.destroy');

// Entradas
Route::get('/entradas', [EntradasController::class, 'Index'])->name('entradas.index');
Route::post('/entradas/store', [EntradasController::class, 'Store'])->name('entradas.store');
Route::get('/entradas/{entrada_id}', [EntradasController::class, 'Destroy'])->name('entradas.destroy');

require __DIR__.'/auth.php';
