@props(['cartItem'])

<fieldset aria-label="Quantity" class="flex items-center justify-between bg-red rounded-full px-4 py-3 w-40">
    <form method="POST" action="{{ route('cart.items.update', $cartItem) }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="quantity" value="{{ $cartItem->quantity - 1 }}">
        <button
            type="submit"
            aria-label="Decrement quantity"
            class="flex items-center justify-center size-5 rounded-full border-2 border-white text-white hover:bg-white hover:text-red transition-colors cursor-pointer shrink-0"
        >
            <x-icons.decrement/>
        </button>
    </form>

    <span
        aria-label="{{ $cartItem->quantity }} in cart"
        aria-live="polite"
        class="text-sm font-semibold text-white">
        {{ $cartItem->quantity }}
    </span>

    <form method="POST" action="{{ route('cart.items.update', $cartItem) }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="quantity" value="{{ $cartItem->quantity + 1 }}">
        <button
            type="submit"
            aria-label="Increment quantity"
            class="flex items-center justify-center size-5 rounded-full border-2 border-white text-white hover:bg-white hover:text-red transition-colors cursor-pointer shrink-0"
        >
            <x-icons.increment/>
        </button>
    </form>
</fieldset>
