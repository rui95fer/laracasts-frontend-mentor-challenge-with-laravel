<?php

namespace App\Models;

use Database\Factories\CartFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['session_id'])]
class Cart extends Model
{
    /** @use HasFactory<CartFactory> */
    use HasFactory;

    public static function ifExists(): ?Cart
    {
        return static::with('items.product')
            ->where('session_id', session()->getId())
            ->first();
    }

    public static function ensureExists(): Cart
    {
        return static::firstOrCreate(['session_id' => session()->getId()]);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    protected function totalQuantity(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->items->sum('quantity'),
        );
    }

    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->items->sum(fn (CartItem $item) => $item->subtotal),
        );
    }
}
