<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    @yield('styles')
</head>

<body class="container mx-auto mt-10 mb-10 max-w-lg">
    <div class="min-h-screen">
        @include('layouts.navigation')
        
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl mb-4">@yield('title')</h1>
    </div>
    <div x-data="{ flash: true }">
        @if (session()->has('success'))
            <div x-show="flash" class="relative mb-10 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700" role="alert">
                <strong class="font-bold">Success!</strong>
                <div>{{ session('success') }}</div>
                <span class="absolute top-0 bottom-0 px-4 py-3 right-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                         stroke-width="1.5" @click="flash = false"
                         stroke="currentColor" class="h-6 w-6 cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </div>
        @endif
    </div>
    <div>@yield('content')</div>
    @livewireScripts
           <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('livewire:init', function () {
            window.addEventListener('alert', event => { 
                alert(event.detail.message); 
            });
        });
    </script>
    <div>@yield('script')</div>
</body>
</html>
