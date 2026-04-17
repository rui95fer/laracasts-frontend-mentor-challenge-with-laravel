<x-layouts.app>
    <main class="min-h-screen py-12 px-6">
        <div class="max-w-360 mx-auto flex flex-col lg:flex-row gap-8">
            {{-- Products --}}
            <section class="flex-1 flex flex-col gap-8">
                <h1 class="text-4xl font-bold text-rose-900">Desserts</h1>

                <ul class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <li>
                            <x-product :product="$product" :cartItem="$cartItems->get($product->id)"/>
                        </li>
                    @endforeach
                </ul>
            </section>

            {{-- Cart --}}
            <x-cart :cart="$cart"/>
        </div>
    </main>

</x-layouts.app>
