@extends('layouts.custom')

@section('content')
<h2 class="text-3xl pt-5 font-bold">Transaction history</h2>

@include('search-bar')

<div class="w-full h-full flex justify-center items-center">
    <div style="margin-left: 10px;">
        @foreach ($transactions as $transaction)
            <div class="transaction-item mb-4 p-4 bg-gray-100 rounded shadow">
                <p><strong>User:</strong> {{ $transaction->user_id }}</p>
                <p><strong>Amount:</strong> {{ $transaction->amount }} {{$transaction->valuta}}</p>
                <p><strong>Description:</strong> {{ $transaction->description }}</p>
                <p><strong>type :</strong> {{ $transaction->type }}</p>

            </div>
        @endforeach
    </div>
</div>

<div class="pagination mt-4">
    {{ $transactions->links() }}
</div>
@endSection