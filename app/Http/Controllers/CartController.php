<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function addOne(Product $product): RedirectResponse
    {
        $cart = Cart::ensureExists();

        $cartItem = $cart->items()->firstOrCreate(
            ['product_id' => $product->id],
            ['quantity' => 0],
        );

        $cartItem->increment('quantity');

        return back();
    }
}
