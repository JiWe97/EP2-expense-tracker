<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="flex">
        <!-- Vertical Navbar -->
        <nav class="w-1/6 text-white bg-gray-200 dark:bg-gray-800 h-screen">
            <!-- Navbar content goes here -->
            <!-- Example: -->
            <ul class="p-4">
                <li><a href="{{ route('categories.index') }}">Categories</a></li>
                <li><a href="{{ route('budgets.index') }}">Budgets</a></li>
                <li><a href="{{ route('transactions.index') }}">Transactions</a></li>
            </ul>
        </nav>
    </div>
</x-app-layout>
