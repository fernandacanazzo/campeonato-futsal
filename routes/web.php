<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JogadorController;
use App\Http\Controllers\TimeController;
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

/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/


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
    Route::get('/jogadores', [JogadorController::class, 'show']
    )->name('jogadores.show');
    Route::post('/jogadores', [JogadorController::class, 'store']
    )->name('jogadores.store');
    Route::delete('/jogador/{id}', [JogadorController::class, 'destroy']
    )->name('jogadores.destroy');
    Route::patch('/jogador/{id}', [JogadorController::class, 'update']
    )->name('jogadores.update');
    Route::get('/times', [TimeController::class, 'show']
    )->name('times.show');
});

require __DIR__.'/auth.php';
