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
    aria-labelledby="order-confirmation-heading"
    class="fixed inset-x-4 inset-y-4 m-auto w-auto max-h-[calc(100dvh-2rem)] overflow-y-auto rounded-2xl bg-white p-6 shadow-xl sm:inset-0 sm:m-auto sm:w-140 sm:max-h-[90dvh] sm:p-10 opacity-0 scale-95 open:opacity-100 open:scale-100 starting:open:opacity-0 starting:open:scale-95 transition-all transition-discrete duration-300 ease-out"
>
    <x-icons.order-confirmed class="text-green"/>

    <h2 id="order-confirmation-heading" class="mt-6 text-4xl font-bold leading-tight text-rose-900">Order Confirmed</h2>
    <p class="mt-3 text-sm text-rose-400">We hope you enjoy your food!</p>

    <div class="mt-8 rounded-xl bg-rose-50 overflow-hidden">
        <ul class="px-6">
            @foreach ($cart->items as $item)
                <li class="flex items-center gap-4 py-4 border-b border-rose-100">
                    <img
                        src="{{ Vite::asset('resources/images/' . $item->product->image) }}"
                        alt="{{ $item->product->name }}"
                        class="size-12 rounded-sm object-cover shrink-0"
                    >
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-rose-900 truncate">{{ $item->product->name }}</p>
                        <div class="flex items-center gap-3 mt-1 text-sm">
                            <span class="font-semibold text-red">{{ $item->quantity }}x</span>
                            <span class="text-rose-400">@ {{ $item->product->formatted_price }}</span>
                        </div>
                    </div>
                    <data value="{{ $item->subtotal }}" class="font-semibold text-rose-900 shrink-0">
                        ${{ number_format($item->subtotal, 2) }}
                    </data>
                </li>
            @endforeach
        </ul>

        <dl class="flex items-center justify-between px-6 py-6">
            <dt class="text-sm text-rose-900">Order Total</dt>
            <dd class="text-2xl font-bold text-rose-900">
                <data value="{{ $cart->total_price }}">${{ number_format($cart->total_price, 2) }}</data>
            </dd>
        </dl>
    </div>

    <form method="POST" action="{{ route('cart.destroy') }}" class="mt-6">
        @csrf
        @method('DELETE')
        <button
            type="submit"
            class="w-full bg-red text-white font-semibold py-4 rounded-full hover:bg-red/90 transition-colors cursor-pointer"
        >
            Start New Order
        </button>
    </form>
</div>
