<?php

use App\Http\Controllers\Api\AceiteController;
use App\Http\Controllers\Api\ClientsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MeProtejaController;
use App\Http\Controllers\Api\ConcentreController;
use App\Http\Controllers\Api\ContratoController;
use App\Http\Controllers\Api\CrednetController;
use App\Http\Controllers\Api\GerencieController;
use App\Http\Controllers\Api\MeAviseController;
use App\Http\Controllers\Api\PefinController;
use App\Http\Controllers\Api\ProredeController;

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


Route::middleware('apiJwt')->group(function () {


    Route::prefix('auth')->group(function () {
        Route::post('logout',   [AuthController::class, 'logout']);
        Route::post('refresh',  [AuthController::class, 'refresh']);
        Route::post('me',       [AuthController::class, 'me']);
    });

    Route::prefix('meproteja')->group(function () {

        Route::post('/incluir/empresa', [MeProtejaController::class, 'incluirEmpresa']);
        Route::post('/excluir/empresa', [MeProtejaController::class, 'excluirEmpresa']);
        Route::post('/consultar/empresa', [MeProtejaController::class, 'consultarEmpresa']);

        Route::post('/incluir/socio', [MeProtejaController::class, 'incluirSocio']);
        Route::post('/excluir/socio', [MeProtejaController::class, 'excluirSocio']);
        Route::post('/consultar/socio', [MeProtejaController::class, 'consultarSocio']);

        Route::post('/incluir/dados/', [MeProtejaController::class, 'incluir_dados']);
    });

    Route::prefix('concentre')->group(function () {

        Route::post('/consulta/cnpj', [ConcentreController::class, 'consulta_cnpj']);
        Route::post('/consulta/cpf', [ConcentreController::class, 'consulta_cpf']);

    });

    Route::prefix('prorede')->group(function () {
        Route::post('analyse_sales', [ProredeController::class, 'AnalyseSales']);
        Route::post('partners_orders', [ProredeController::class, 'PartnersOrders']);
    });

    Route::prefix('crednet')->group(function () {
        Route::post('index', [CrednetController::class, 'index']);
        Route::post('consulta/pessoa', [CrednetController::class, 'consulta_pessoa']);
    });

    Route::prefix('contrato')->group(function () {
        Route::get('getAllContrato', [ContratoController::class, 'getAllContrato']);
    });

    Route::prefix('aceite')->group(function () {
        Route::post('setAceiteEletronico', [AceiteController::class, 'setAceiteEletronico']);
        Route::post('getAceiteEletronico', [AceiteController::class, 'getAceiteEletronico']);
    });

    Route::prefix('pefin')->group(function () {
        Route::post('setPefin', [PefinController::class, 'setPefin']);
    });

});

Route::prefix('meavise')->group(function () {
    Route::get('teste', [MeAviseController::class, 'teste']);
});

//Route::post('prorede/analyse_sales', [ProredeController::class, 'AnalyseSales']);
Route::get('gerencie/index', [GerencieController::class, 'index']);
Route::get('/meproteja/sendMail/', [MeProtejaController::class, 'sendMail']);
