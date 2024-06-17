@extends('layouts.custom')

@section('content')
    <h2 class="text-3xl pt-5 font-bold">Transaction history</h2>

    <div class="w-full h-full flex justify-center items-center">
        <div class="ml-2">
            @foreach ($transactions as $transaction)
                <div class="transaction-item mb-4 p-4 bg-gray-100 rounded shadow">
                    <p><strong>Amount:</strong> {{ $transaction->amount }}</p>
                    <p><strong>Description:</strong> {{ $transaction->description }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="pagination mt-4">
        {{ $transactions->links() }}
    </div>
@endsection
