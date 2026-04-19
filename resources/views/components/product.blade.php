@props(['product', 'cartItem' => null])

<article class="flex flex-col gap-8">
    <div class="relative">
        <img
            src="{{ Vite::asset('resources/images/' . $product->image) }}"
            alt="{{ $product->name }}"
            @class(['w-full aspect-4/3 lg:aspect-square rounded-xl object-cover', 'ring-2 ring-red' => $cartItem])
        >

        <div class="absolute -bottom-5 left-1/2 -translate-x-1/2">
            @if ($cartItem)
                <x-product.quantity-stepper :cartItem="$cartItem"/>
            @else
                <form method="POST" action="{{ route('cart.items.store', $product) }}">
                    @csrf
                    <button
                        type="submit"
                        class="flex items-center gap-2 bg-white border border-rose-400 rounded-full px-6 py-3 text-sm font-semibold text-rose-900 whitespace-nowrap hover:border-red hover:text-red transition-colors"
                    >
                        <img src="{{ Vite::asset('resources/images/icon-add-to-cart.svg') }}" alt="" class="size-4">
                        Add to Cart
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="flex flex-col gap-1">
        <p class="text-sm text-rose-400">{{ $product->category }}</p>
        <h3 class="font-semibold text-rose-900">{{ $product->name }}</h3>
        <data value="{{ $product->price }}" class="font-semibold text-red">{{ $product->formattedPrice }}</data>
    </div>
</article>
