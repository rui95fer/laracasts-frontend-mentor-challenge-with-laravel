<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text:ital,wght@0,300..700;1,300..700&display=swap"
          rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<main class="min-h-screen bg-rose-50 py-12 px-6">
    <div class="max-w-360 mx-auto flex flex-col lg:flex-row items-start gap-8">
        {{-- Products --}}
        <section class="flex-1 flex flex-col gap-8">
            <h1 class="text-4xl font-bold text-rose-900">Desserts</h1>

            <ul class="grid lg:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <li class="flex justify-between items-center p-4 rounded bg-white border border-rose-100">
                        <div>
                            <h3 class="font-medium text-rose-900">{{ $product->name }}</h3>
                            <p class="text-sm text-rose-400">{{ $product->category }}</p>
                        </div>
                        <span class="font-bold text-red">${{ number_format($product->price, 2) }}</span>
                    </li>
                @endforeach
            </ul>
        </section>

        {{-- Cart --}}
        <aside class="w-full lg:w-96 bg-white rounded-2xl p-6">
            <h2 class="text-xl font-bold text-red">Your Cart (0)</h2>
        </aside>
    </div>
</main>
</body>
</html>
