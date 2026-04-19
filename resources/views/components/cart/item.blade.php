@props(['item'])

<li class="flex items-center justify-between py-4 border-b border-rose-100 last:border-b-0">
    <div class="flex flex-col gap-1">
        <p class="text-sm font-semibold text-rose-900">{{ $item->product->name }}</p>

        <div class="flex items-center gap-3 text-sm">
            <span class="font-semibold text-red" aria-label="{{ $item->quantity }} times">{{ $item->quantity }}x</span>
            <span class="text-rose-400">@ {{ $item->product->formatted_price }}</span>
            <data value="{{ $item->subtotal }}" class="font-semibold text-rose-500">${{ number_format($item->subtotal, 2) }}</data>
        </div>
    </div>

    <form method="POST" action="{{ route('cart.items.destroy', $item) }}">
        @csrf
        @method('DELETE')
        <button
            type="submit"
            aria-label="Remove {{ $item->product->name }}"
            class="flex items-center justify-center size-5 rounded-full border-2 border-rose-400 text-rose-400 hover:border-rose-900 hover:text-rose-900 transition-colors cursor-pointer shrink-0">
            <x-icons.remove-item/>
        </button>
    </form>
</li>
