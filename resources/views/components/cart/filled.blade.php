@props(['cart'])

<div class="mt-2">
    <ul>
        @foreach ($cart->items as $item)
            <x-cart.item :item="$item"/>
        @endforeach
    </ul>

    {{-- Order Total --}}
    <dl class="flex items-center justify-between border-t border-rose-100 py-6">
        <dt class="text-sm text-rose-900">Order Total</dt>
        <dd class="text-2xl font-bold text-rose-900">
            <data value="{{ $cart->total_price }}">${{ number_format($cart->total_price, 2) }}</data>
        </dd>
    </dl>
</div>

{{-- Carbon Neutral --}}
<div class="flex items-center justify-center gap-2 bg-rose-50 rounded-lg p-4">
    <x-icons.carbon-neutral class="text-green shrink-0"/>
    <p class="text-sm text-rose-900">This is a <span class="font-semibold">carbon-neutral</span> delivery</p>
</div>

{{-- Confirm Order --}}
<button
    type="button"
    popovertarget="order-confirmation"
    class="mt-4 w-full bg-red text-white font-semibold py-4 rounded-full hover:bg-red/90 transition-colors cursor-pointer"
>
    Confirm Order
</button>

{{-- Order Confirmation Popover --}}
<div
    id="order-confirmation"
    popover
    class="fixed inset-0 m-auto w-140 rounded-xl bg-white p-10 shadow-xl opacity-0 scale-95 open:opacity-100 open:scale-100 starting:open:opacity-0 starting:open:scale-95 transition-all transition-discrete duration-300 ease-out backdrop:bg-black/50"
>
    <p>Order confirmed! This is a test message.</p>
    <button popovertarget="order-confirmation" popovertargetaction="hide">Close</button>
</div>
