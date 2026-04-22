@props(['cart'])

<aside class="flex flex-col w-full lg:w-96 lg:self-start lg:sticky lg:top-8 bg-white rounded-xl p-6">
    <h2 class="text-xl font-bold text-red">Your Cart ({{ $cart?->total_quantity ?? 0 }})</h2>

    @if ($cart && $cart->items->isNotEmpty())
        <x-cart.filled :cart="$cart"/>
    @else
        <x-cart.empty/>
    @endif
</aside>
