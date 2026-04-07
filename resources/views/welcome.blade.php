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
<div class="flex flex-col items-center justify-center h-screen gap-8">
    <h1 class="text-4xl font-bold text-rose-900">{{ config('app.name', 'Laravel') }}</h1>

    <div class="flex gap-4">
        <div class="size-16 rounded bg-red" title="red"></div>
        <div class="size-16 rounded bg-green" title="green"></div>
        <div class="size-16 rounded bg-rose-50 border border-rose-100" title="rose-50"></div>
        <div class="size-16 rounded bg-rose-100" title="rose-100"></div>
        <div class="size-16 rounded bg-rose-300" title="rose-300"></div>
        <div class="size-16 rounded bg-rose-400" title="rose-400"></div>
        <div class="size-16 rounded bg-rose-500" title="rose-500"></div>
        <div class="size-16 rounded bg-rose-900" title="rose-900"></div>
    </div>
</div>
</body>
</html>
