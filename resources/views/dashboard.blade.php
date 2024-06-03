

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
     @section('content')
    

    <x-progress-bar></x-progress-bar>

    <a href="{{ route('transaction.create') }}" class="link">Add</a>

    @endSection

   
</x-app-layout>

