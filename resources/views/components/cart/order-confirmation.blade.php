@props(['cart'])

{{-- Order Confirmation Modal --}}
{{-- TODO: Add show/hide toggle logic --}}
<div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-rose-900/50 p-0 sm:p-6">
    <div class="w-full sm:max-w-lg bg-white rounded-t-2xl sm:rounded-2xl p-10 overflow-y-auto max-h-[90vh]">

        {{-- Confirmed Icon --}}
        <x-icons.order-confirmed class="text-green"/>

        {{-- Heading --}}
        <h2 class="text-3xl sm:text-4xl font-bold text-rose-900 mt-6 leading-tight">Order<br>Confirmed</h2>
        <p class="text-sm text-rose-400 mt-2">We hope you enjoy your food!</p>

        {{-- Items --}}
        <div class="mt-8 bg-rose-50 rounded-xl">
            @foreach ($cart->items as $item)
                <div class="flex items-center justify-between gap-4 p-4 border-b border-rose-100 last:border-b-0">
                    <div class="flex items-center gap-4 min-w-0">
                        <img
                            src="{{ Vite::asset('resources/images/' . $item->product->image) }}"
                            alt="{{ $item->product->name }}"
                            class="size-12 rounded-md object-cover shrink-0"
                        >
                        <div class="flex flex-col gap-1 min-w-0">
                            <p class="text-sm font-semibold text-rose-900 truncate">{{ $item->product->name }}</p>
                            <div class="flex items-center gap-3 text-sm">
                                <span class="font-semibold text-red">{{ $item->quantity }}x</span>
                                <span class="text-rose-400">@ {{ $item->product->formatted_price }}</span>
                            </div>
                        </div>
                    </div>
                    <span class="font-semibold text-rose-900 whitespace-nowrap">${{ number_format($item->subtotal, 2) }}</span>
                </div>
            @endforeach

            {{-- Order Total --}}
            <div class="flex items-center justify-between p-6 border-t border-rose-100">
                <span class="text-sm text-rose-900">Order Total</span>
                <span class="text-2xl font-bold text-rose-900">${{ number_format($cart->total_price, 2) }}</span>
            </div>
        </div>

        {{-- Start New Order --}}
        <button type="button" class="mt-8 w-full bg-red text-white font-semibold py-4 rounded-full hover:bg-red/90 transition-colors cursor-pointer">
            Start New Order
        </button>
    </div>
</div>
