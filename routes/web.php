<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GraficoController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [HomeController::class, 'create'])->name('home.create');
Route::delete('/{id}', [HomeController::class, 'destroy'])->name('home.delete');
Route::put('/{id}', [HomeController::class, 'update'])->name('home.update');

Route::get('/grafico', [GraficoController::class, 'index'])->name('grafico.index');
