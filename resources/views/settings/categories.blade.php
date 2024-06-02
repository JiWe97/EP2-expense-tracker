<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- fontawesome --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">


        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    </head>
    <body>
        This is the category blade
        <div class="flex flex-col space-y-4">
        @foreach($categories as $category)
        <ul class="list-none p-0">
            <li class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-full flex justify-center items-center" style="background-color: {{ $category->color }}">
                    <i class="{{ $category->icon }}" style="color: #fff;"></i>
                    {{-- <i class="{{ $category->icon }}" style="color: #000;"></i> --}}
                </div>
                <span class="text-sm font-medium">{{ $category->name }}</span>
            </li>
        </ul>
        @endforeach
        </div>
    </body>
    </html>