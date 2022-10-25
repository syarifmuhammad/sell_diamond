<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

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

Route::get('/', [HomePageController::class, 'index']);
Route::group([
    'prefix' => 'product'
], function($router){
    Route::get('{category}', [ProductController::class, 'index']);
    Route::post('buy/details', [TransactionController::class, 'check']);
    Route::post('buy/confirm', [TransactionController::class, 'buy']);
});

Route::group([
    'prefix' => 'transaction'
], function($router){
    Route::get('{uuid}', [TransactionController::class, 'index']);
});
