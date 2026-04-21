<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function destroy(): RedirectResponse
    {
        Cart::ifExists()?->items()->delete();

        return back();
    }
}
