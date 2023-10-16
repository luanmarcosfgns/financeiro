<?php

use App\Http\Controllers\AliquotaController;
use App\Http\Controllers\AliquotasItemController;
use App\Http\Controllers\AnexosVendaController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\CotationController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\EntrevistaController;
use App\Http\Controllers\PerguntaController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\ServicosAnexoController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\VendasPagamentoController;
use App\Http\Controllers\VendasServicoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'], function ($router) {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('me', [UserController::class, 'me']);


});

Route::group([
    'middleware' => 'auth'],
    function ($router) {
        Route::resource('users', UsuariosController::class)->except(['create', 'edit']);
        Route::resource('contas', ContaController::class)->except(['create', 'edit']);
    });
