<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ConsultorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|


Route::get('/', function () {
    return view('welcome');
});

*/

Route::get('/', ConsultorController::class .'@index')->name('consultor.index');
Route::get('/getDadosModal/{id}', ConsultorController::class .'@getDadosModal')->name('consultor.get');
Route::post('/import',[ConsultaController::class,'import'])->name('import');