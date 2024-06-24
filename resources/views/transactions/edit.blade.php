<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    @include('layouts.styles')

    @section('content')
        @livewire('transaction-form', ['transaction' => $transaction])
    @endsection
</x-app-layout>
