<?php

use App\Http\Controllers\ControladorUsuarios;
use App\Http\Controllers\ControladorCategorias;
use App\Http\Controllers\ControladorTransacoes;


Route::get('/usuarios', [ControladorUsuarios::class, 'listarUsuarios']);
Route::post('/usuarios/criar', [ControladorUsuarios::class, 'armazenarUsuario']);
Route::delete('/usuarios/deletar/{id}', [ControladorUsuarios::class, 'deletarUsuario']);
Route::put('/usuarios/atualizar/{id}', [ControladorUsuarios::class, 'atualizarUsuario']);


Route::get('/categorias', [ControladorCategorias::class, 'listarCategorias']);
Route::post('/categorias/criar', [ControladorCategorias::class, 'armazenarCategoria']);
Route::delete('/categorias/deletar/{id}', [ControladorCategorias::class, 'deletarCategoria']);


Route::get('/transacoes', [ControladorTransacoes::class, 'listarTransacoes']);
Route::get('/transacoes/usuario/{usuario}', [ControladorTransacoes::class, 'listarTransacoesUsuario']);
Route::get('/transacoes/categoria/{categoria}', [ControladorTransacoes::class, 'listarTransacoesCategoria']);
Route::get('/transacoes/tipo/{tipo}', [ControladorTransacoes::class, 'listarTransacoesTipo']);
Route::post('/transacoes/criar', [ControladorTransacoes::class, 'armazenarTransacao']);
Route::delete('/transacoes/{id}', [ControladorTransacoes::class, 'deletarTransacao']);
Route::delete('/transacoes/deletar/{id}', [ControladorTransacoes::class, 'deletarTransacao']);
