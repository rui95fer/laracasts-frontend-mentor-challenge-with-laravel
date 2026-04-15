<?php

use App\Http\Controllers\CartItemController;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('products.index', [
        'products' => Product::all(),
        'cart' => Cart::ifExists(),
    ]);
});

Route::post('/cart/items/{product}', [CartItemController::class, 'store'])->name('cart.items.store');
