<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
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

    public function update(UpdateCartItemRequest $request, CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->belongsToCurrentSession(), 403);

        $cartItem->setQuantity($request->validated('quantity'));

        return back();
    }

    public function destroy(CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->belongsToCurrentSession(), 403);

        $cartItem->delete();

        return back();
    }
}
