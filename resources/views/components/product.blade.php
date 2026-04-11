@props(['product'])

<div>
    <img src="{{ Vite::asset('resources/images/' . $product->image) }}" alt="{{ $product->name }}">

    <button type="button">
        <img src="{{ Vite::asset('resources/images/icon-add-to-cart.svg') }}" alt="">
        Add to Cart
    </button>

    <p>{{ $product->category }}</p>
    <h3>{{ $product->name }}</h3>
    <p>{{ $product->formattedPrice }}</p>
</div>
