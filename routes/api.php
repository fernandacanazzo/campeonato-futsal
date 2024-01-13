<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthApiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JogadorController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\ClassificacaoController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'show'])->middleware(['auth:sanctum', 'verified'])->name('home');

Route::middleware('auth:sanctum')->group(function () {

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

Route::middleware('guest')->group(function () {

    Route::post('/login', [AuthApiController::class, 'login']);

});

    
