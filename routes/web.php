<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JogadorController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\PartidaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/login', function () {
    return Inertia::render('Login');
});

Route::get('/', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //jogadores
    Route::get('/jogadores', [JogadorController::class, 'show']
    )->name('jogadores.show');
    Route::post('/jogadores', [JogadorController::class, 'store']
    )->name('jogadores.store');
    Route::delete('/jogador/{id}', [JogadorController::class, 'destroy']
    )->name('jogadores.destroy');
    Route::patch('/jogador/{id}', [JogadorController::class, 'update']
    )->name('jogadores.update');
    //times
    Route::get('/times/busca', [TimeController::class, 'busca']
    )->name('times.busca');//para preencher as opções do select na tela de jogadores
    Route::get('/times', [TimeController::class, 'show']
    )->name('times.show');
    Route::post('/times', [TimeController::class, 'store']
    )->name('times.store');
    Route::delete('/time/{id}', [TimeController::class, 'destroy']
    )->name('times.destroy');
    Route::patch('/time/{id}', [TimeController::class, 'update']
    )->name('times.update');

    //partidas
    Route::get('/partidas', [PartidaController::class, 'show']
    )->name('partidas.show');
    Route::post('/partidas', [PartidaController::class, 'store']
    )->name('partidas.store');
    Route::delete('/partida/{id}', [PartidaController::class, 'destroy']
    )->name('partidas.destroy');
    Route::patch('/partida/{id}', [PartidaController::class, 'update']
    )->name('partidas.update');
});

require __DIR__.'/auth.php';
