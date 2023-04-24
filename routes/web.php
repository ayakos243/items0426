<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//ダッシュボード表示
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


    Route::prefix('items')->group(function () {

    //商品一覧を表示
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('items');

    //商品登録画面を表示
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'create'])->name('create');

    //商品登録
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('add');

    //商品登録
    Route::post('/store', [App\Http\Controllers\ItemController::class, 'store'])->name('store');

    //商品詳細画面を表示
    Route::get('/detail/{id}', [App\Http\Controllers\ItemController::class, 'show'])->name('show');

    //商品編集画面を表示
    Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('edit');

    //商品情報更新
    Route::post('/update/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('update');

    //商品削除
    Route::post('/delete/{id}', [App\Http\Controllers\ItemController::class, 'delete'])->name('delete');

    //csvダウンロード
    Route::get('/download', [App\Http\Controllers\ItemController::class, 'download'])->name('download');
    });