<?php

use App\Http\Controllers\CartController;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'products' => Product::all(),
        'cart' => Cart::ifExists(),
    ]);
});

Route::post('/cart/{product}', [CartController::class, 'addOne'])->name('cart.addOne');
