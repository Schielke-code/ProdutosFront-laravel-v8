<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProdutosController;
use \Illuminate\Support\Facades\Artisan;

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


//Route::get('/', ['uses' => 'ProdutosController@index', 'as' => 'index']);
Route::get('/', [ProdutosController::class, 'index'])->name('index');
Route::group(['prefix'=>'produtos'], function(){
    Route::get('/create', [ProdutosController::class, 'create'])->name('produtos.create');
    Route::get('/list', [ProdutosController::class, 'list'])->name('produtos.list');
    Route::post('/store', [ProdutosController::class, 'store'])->name('produtos.store');
    Route::get('/delete/{id?}', [ProdutosController::class, 'destroy'])->name('produtos.delete');
    Route::get('/show/{id?}', [ProdutosController::class, 'show'])->name('produtos.show');

});
