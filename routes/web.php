<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Каталог товаров
    Route::get('/catalog', [\App\Http\Controllers\ProductController::class, 'index'])->name('catalog');
    // Корзина
    Route::get('/cart', [\App\Http\Controllers\BasketController::class, 'index'])->name('cart');
    // Добавление товара в корзину
    Route::post('/addToBasket', [\App\Http\Controllers\BasketController::class, 'store'])->name('addToBasket');
    // Список заказов
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders');
    // Сохранение заказа
    Route::post('/order/save', [\App\Http\Controllers\OrderController::class, 'store'])->name('saveOrder');
    // Удаление заказа
    Route::post('/order/remove/{id}', [\App\Http\Controllers\OrderController::class, 'destroy'])->name('removeOrder');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
