<?php

use App\Http\Controllers\AliquotaController;
use App\Http\Controllers\AliquotasItemController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\EnderecoController;
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
        Route::get('aliquotas/list', [AliquotaController::class, 'list']);
        Route::get('categorias/list', [CategoriaController::class, 'list']);
        Route::resource('contatos', ContatoController::class)->except(['create', 'edit']);
        Route::resource('enderecos', EnderecoController::class)->except(['create', 'edit']);
        Route::resource('users', UsuariosController::class)->except(['create', 'edit']);
        Route::resource('business', BusinessController::class)->except(['create', 'edit']);
        Route::resource('categorias', CategoriaController::class)->except(['create', 'edit']);
        Route::resource('aliquotas', AliquotaController::class)->except(['create', 'edit']);
        Route::resource('aliquotas_items', AliquotasItemController::class)->except(['create', 'edit']);
        Route::resource('servicos', ServicoController::class)->except(['create', 'edit']);
        Route::resource('servicos_anexos', ServicosAnexoController::class)->except(['create', 'edit']);
        Route::resource('servicos_anexos', ServicosAnexoController::class)->except(['create', 'edit']);
        Route::resource('sessions', SessionController::class)->except(['create', 'edit']);
        Route::resource('vendas', VendaController::class)->except(['create', 'edit']);
        Route::resource('vendas_pagamentos', VendasPagamentoController::class)->except(['create', 'edit']);
        Route::resource('vendas_servicos', VendasServicoController::class)->except(['create', 'edit']);

});
