<?php

use App\Http\Controllers\Api\AceiteController;
use Illuminate\Support\Facades\Route;

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
    return redirect('https://www.positivaconsultas.com.br/');
});

Route::get('/teste', [AceiteController::class, 'teste']);
Route::get('/aceite/{token}', [AceiteController::class, 'verificar'])->name('aceite');
Route::post('/aceite/{token}', [AceiteController::class, 'assinar'])->name('assinar');

Auth::routes();
