<style>
.transaction-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border: 1px solid #ddd;
}

.transaction-table th, .transaction-table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    color: white;
}
.card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: left;
}

.bank-card {
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 20px;
    margin: 15px;
    width: 350px;
    transition: transform 0.2s ease-in-out;
    border: 1px solid #ddd;
    cursor: pointer;
}

.bank-card.selected {
    background-color: #4A90E2; /* Highlight color for selected cards */
    color: white;
    border: 2px solid #4A90E2;
}
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-gray-800">
        <div class="w-5/6 p-8 text-white">
            @if($bankingRecords->isNotEmpty())
                <div class="mb-4">
                    <h2 class="text-lg font-bold mb-2">Total Balance: &#8364; {{ $totalBalance }}</h2>
                </div>
                <div class="card-container" id="card-container">
                    @foreach($bankingRecords as $record)
                        <div class="bank-card" data-bank-name="{{ $record->bank_name }}">
                            <div>
                                <h2><strong>{{ $record->name }}</strong></h2>
                                <p><strong>Bank Name:</strong> {{ $record->bank_name }}</p>
                                <p><strong>Account Number:</strong> {{ $record->account_number }}</p>
                                <p><strong>Balance: &#8364;</strong> {{ $record->balance }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button id="filter-button" class="mt-4 p-2 bg-blue-500 text-white">Filter Transactions</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectedBanks = [];
            const cards = document.querySelectorAll('.bank-card');

            cards.forEach(card => {
                card.addEventListener('click', function () {
                    const bankName = this.getAttribute('data-bank-name');
                    if (selectedBanks.includes(bankName)) {
                        selectedBanks.splice(selectedBanks.indexOf(bankName), 1);
                        this.classList.remove('selected');
                    } else {
                        selectedBanks.push(bankName);
                        this.classList.add('selected');
                    }
                });
            });

            document.getElementById('filter-button').addEventListener('click', function () {
                const url = new URL(window.location.href);
                url.searchParams.set('selectedBankNames', selectedBanks.join(','));
                window.location.href = url.toString();
            });
        });
    </script>
</x-app-layout>
