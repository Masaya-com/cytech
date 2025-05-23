<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;


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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // 商品一覧
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // 商品新規登録フォーム
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    // 商品登録処理
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // 商品詳細表示
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // 商品編集フォーム
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

    // 商品更新処理
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    // 商品削除処理
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});