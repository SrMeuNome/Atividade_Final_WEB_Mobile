<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\JogadorController;
use App\Http\Controllers\FirebaseController;

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

Route::resources([
    "turma" => TurmaController::class,
    "aluno" => AlunoController::class,
    "jogador" => JogadorController::class
]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get', [FirebaseController::class, 'getData']);

Route::get('/insert', [FirebaseController::class, 'insertTest']);
