<?php

use App\Http\Controllers\Api\ClientsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MeProtejaController;
use App\Http\Controllers\Api\ConcentreController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/login',    [AuthController::class, 'login']);

Route::prefix('auth')->middleware('apiJwt')->group(function () {
    Route::post('logout',   [AuthController::class, 'logout']);
    Route::post('refresh',  [AuthController::class, 'refresh']);
    Route::post('me',       [AuthController::class, 'me']);
});

Route::get('/clients', [ClientsController::class, 'index']);

Route::prefix('meproteja')->middleware('apiJwt')->group(function () {
    Route::post('/incluir/empresa', [MeProtejaController::class, 'incluirEmpresa']);
});

Route::prefix('concentre')->middleware('apiJwt')->group(function () {
    Route::post('/consulta/cnpj', [ConcentreController::class, 'consulta_cnpj']);
    Route::post('/consulta/cpf', [ConcentreController::class, 'consulta_cpf']);
});
