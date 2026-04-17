@props(['quantity'])

<div role="group" aria-label="Quantity" class="flex items-center justify-between bg-red rounded-full px-4 py-3 w-40">
    <button
        type="button"
        aria-label="Decrement quantity"
        class="flex items-center justify-center size-5 rounded-full border-2 border-white text-white hover:bg-white hover:text-red transition-colors cursor-pointer shrink-0"
    >
        <x-icons.decrement/>
    </button>

    <span aria-label="{{ $quantity }} in cart" aria-live="polite" class="text-sm font-semibold text-white">{{ $quantity }}</span>

    <button
        type="button"
        aria-label="Increment quantity"
        class="flex items-center justify-center size-5 rounded-full border-2 border-white text-white hover:bg-white hover:text-red transition-colors cursor-pointer shrink-0"
    >
        <x-icons.increment/>
    </button>
</div>
