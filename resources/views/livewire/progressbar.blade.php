<div wire:poll.10s="refreshProgress">
    @push('styles')
        @include('layouts.styles')
    @endpush

    @if (session()->has('alert'))
        <div class="alert alert-{{ session('alert')['type'] }}">
            {{ session('alert')['message'] }}
        </div>
    @endif

    <div class="mb-4">
        <div class="mb-4">
            <p>Total Budget: € {{ $budget->amount }}</p>
            <p>Total Spent: € {{ $transactions->sum('amount') }}</p>
            <p>Remaining: € {{ $budget->amount - $transactions->sum('amount') }}</p>
        </div>
        <div class="mb-4">
            <h1 class="text-black pr-10 pt-2 sm:pt-5 sm:pr-80">
                <span class="text-xs text-grey-400">{{ round($percentage) }}%</span>
            </h1>
            <div class="flex mt-2 mr-10 sm:mr-80 h-4 relative w-60 rounded-full overflow-hidden">
                <div class="w-full h-full bg-gray-200 absolute"></div>
                <div class="h-full absolute {{ $colorClass }}" style="width: {{ $percentage }}%"></div>
            </div>
        </div>
    </div>

    <div class="transactions">
        <h2 class="text-l font-semibold underline">Transactions</h2>
        <ul>
            @foreach($transactions as $transaction)
                <li>
                    <a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}">
                        <p><i class="fa fa-coins"></i> {{ $transaction->description }} - €{{ $transaction->amount }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
