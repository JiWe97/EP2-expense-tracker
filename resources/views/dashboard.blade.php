<style>
.transaction-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border: 1px solid #ddd;
}

.transaction-table th,.transaction-table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    color: white;
}


</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="bg-gray-800 ">
        <div class="w-5/6 p-8 text-white">
            @if($bankingRecords->isNotEmpty())
                <div class="mb-4">
                    <h2 class="text-lg font-bold mb-2">Total Balance: {{ $totalBalance }}</h2>
                </div>
            @foreach($bankingRecords as $record)
    <div class="mb-4 shadow-md rounded-lg p-6">
        <a href="{{ route('dashboard', ['selectedBankName' => $record->bank_name]) }}">
    <h4 class="text-lg font-bold mb-2">{{ $record->name }}</h4>
</a>

        <span id="details-{{ $record->id }}" style="display:block;">
            <p><strong>Bank Name:</strong> {{ $record->bank_name }}</p>
            <p><strong>Account Number:</strong> {{ $record->account_number }}</p>
            <p><strong>Balance:</strong> {{ $record->balance }}</p>
        </span>
    </div>
@endforeach
            @else
                <p>No banking information found.</p>
            @endif
        </div>
    
    </div>
    <!-- Transaction History -->
    <div class="bg-gray-800 mt-4 p-8 text-white">
    <h3 class="text-lg font-bold mb-2">Transaction History</h3>
    <table class="transaction-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Type</th>
                <th>Category</th>
                <th>Bank</th>
                <th>Attachment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->type }}</td>
                    <td>{{ $transaction->category->name?? 'N/A' }}</td>
                    <td>{{ $transaction->bankingRecord->bank_name?? 'N/A' }}</td>
                    <td>{{ $transaction->attachments_count > 0? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Display pagination links -->
    {{ $transactions->links() }}
</div>
    
</x-app-layout>

