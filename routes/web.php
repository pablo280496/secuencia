<?php

use App\Http\Controllers\ElementosPizarraController;
use App\Http\Controllers\UsuarioPizarraController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizarraController;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ruta para mostrar el formulario de creación de pizarra
Route::get('/pizarras/register', function () {
    return view('pizarra.create');
});

// Ruta para mostrar el formulario de creación de pizarra igual lo hace pero primero llamo a la funcion del controllador createForm
Route::get('/pizarra/register/form',[PizarraController::class, 'createForm'])->name('create.form');


Route::get('/pizarras/dashboard/', function () {
    return view('pizarra.dashboard');
    })->name('pizarra.dashboard');

Route::get('/pizarra/dashboard/{id}', [PizarraController::class, 'mostrarPizarra'])->name('pizarra.dashboard1');
Route::get('/pizarra/dashboard/{id}', [PizarraController::class, 'esPizarra'])->name('pizarra.dashboard');


Route::post('/unirse-pizarra', [PizarraController::class, 'unirsePizarra'])->name('unirse.pizarra');

Route::middleware(['web'])->group(function () {
    // Aquí debes definir tus rutas que necesitan protección CSRF
    // Por ejemplo, las rutas de crear y editar pizarras
    Route::post('/pizarras', [PizarraController::class, 'create'])->name('pizarra.create.formulario');
});

Route::post('/pizarra/actualizar', 'PizarraController@actualizar');

Route::post('/elementos-pizarra', [ElementosPizarraController::class, 'crearElemento']);
Route::post('/actualizar-posicion/{id}', [ElementosPizarraController::class, 'actualizarPosicion'])->name('elementos.actualizar-posicion');
Route::delete('/eliminar-elementos-por-tipo/{tipo}', [ElementosPizarraController::class,'eliminarElementosPorTipo']);





