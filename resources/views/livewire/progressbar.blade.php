<div wire:poll.10s="refreshProgress">
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
        .alert-warning {
            color: #8a6d3b;
            background-color: #fcf8e3;
            border-color: #faebcc;
        }
    </style>
    @if (session()->has('alert'))
        <div class="alert alert-{{ session('alert')['type'] }}">
            {{ session('alert')['message'] }}
        </div>
    @endif

    <div class="mb-4">

        <div class="mb-4">
            <p>Total Budget: {{ $budget->amount }}</p>
            <p>Total Spent: {{ $transactions->sum('amount') }}</p>
            <p>Remaining: {{ $budget->amount - $transactions->sum('amount') }}</p>
        </div>
        <div class="mb-4">
            <h1 class="text-black pr-10 pt-2 sm:pt-5 sm:pr-80 pt-5">
                <span class="text-xs text-grey-400">{{ round($percentage) }}%</span>
            </h1>
            <div class="flex mt-2 mr-10 sm:mr-80 h-4 relative w-60 rounded-full overflow-hidden">
                <div class="w-full h-full bg-gray-200 absolute"></div>
                <div class="h-full absolute {{ $colorClass }}" style="width: {{ $percentage }}%"></div>
            </div>
        </div>
    </div>

    <div class="transactions">
        <h2>Transactions</h2>
        <ul>
            @foreach($transactions as $transaction)
                <li>
                    <p>{{ $transaction->description }} - €{{ $transaction->amount }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>
