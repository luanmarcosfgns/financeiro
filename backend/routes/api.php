<?php

use App\Http\Controllers\AliquotaController;
use App\Http\Controllers\AliquotasItemController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\ServicosAnexoController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UsuariosController;
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
            Route::resource('contatos',ContatoController::class)->except(['create','edit']);
            Route::resource('usuarios', UsuariosController::class)->except(['create','edit']);
            Route::resource('business', BusinessController::class)->except(['create','edit']);
            Route::resource('categorias', CategoriaController::class)->except(['create','edit']);
            Route::resource('aliquotas', AliquotaController::class)->except(['create','edit']);
            Route::resource('aliquotas_items', AliquotasItemController::class)->except(['create','edit']);
            Route::resource('servicos', ServicoController::class)->except(['create','edit']);
            Route::resource('servicos_anexos', ServicosAnexoController::class)->except(['create','edit']);
            Route::resource('servicos_anexos', ServicosAnexoController::class)->except(['create','edit']);
            Route::resource('sessions', SessionController::class)->except(['create','edit']);
    });
