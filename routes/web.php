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
