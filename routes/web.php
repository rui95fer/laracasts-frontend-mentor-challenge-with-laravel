<?php

use App\Http\Controllers\CartItemController;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $cart = Cart::ifExists();

    return view('products.index', [
        'products' => Product::all(),
        'cart' => $cart,
        'cartItems' => $cart?->items->keyBy('product_id') ?? collect(),
    ]);
});

Route::post('/cart/items/{product}', [CartItemController::class, 'store'])->name('cart.items.store');
Route::patch('/cart/items/{cartItem}', [CartItemController::class, 'update'])->name('cart.items.update');
Route::delete('/cart/items/{cartItem}', [CartItemController::class, 'destroy'])->name('cart.items.destroy');
