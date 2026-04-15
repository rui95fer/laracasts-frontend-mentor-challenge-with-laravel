<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class CartItemController extends Controller
{
    public function store(Product $product): RedirectResponse
    {
        $cart = Cart::ensureExists();

        $cart->addProduct($product);

        return back();
    }
}
