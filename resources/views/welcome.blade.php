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
<div class="flex flex-col items-center justify-center min-h-screen gap-8 py-12">
    <h1 class="text-4xl font-bold text-rose-900">{{ config('app.name', 'Laravel') }}</h1>

    <ul class="flex flex-col gap-2 w-80">
        @foreach ($products as $product)
            <li class="flex justify-between items-center p-4 rounded bg-rose-50 border border-rose-100">
                <div>
                    <p class="font-semibold text-rose-900">{{ $product->name }}</p>
                    <p class="text-sm text-rose-400">{{ $product->category }}</p>
                </div>
                <span class="font-bold text-rose-500">${{ number_format($product->price, 2) }}</span>
            </li>
        @endforeach
    </ul>
</div>
</body>
</html>
