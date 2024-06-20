{{-- transaction-search.blade.php --}}
<div class="dashboard-mb-4">
    <div class="dashboard-container">
        <h1 class="text-2xl font-bold">Total Balance: € {{ $totalBalance }}</h1>
        <div class="dashboard-w-5/6 dashboard-p-8 dashboard-text-grey-800">
            @if($bankingRecords->isNotEmpty())
                <div class="dashboard-card-container">
                    @foreach($bankingRecords as $record)
                        <a 
                            wire:click="toggleBankSelection({{ $record->id }})" 
                            class="dashboard-btn {{ in_array($record->id, $selectedBankIds) ? 'dashboard-selected' : '' }}">
                            <h2><strong>{{ $record->name }}</strong></h2> 
                            <p>Bank Name: {{ $record->bank_name }}</p>
                            <p>Balance: &#8364; {{ $record->balance }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <p>No banking information found.</p>
            @endif
        </div>
        <div>
            <div id="pieChart"></div>
            <div id="chart_div" style="width: 50%; height: 400px;"></div>
        </div>
        <div class="dashboard-mb-4" x-data="{ open: false }" @reset-search-form.window="clearFields()">
            <button class="search-btn" @click="open = !open">
                <i class="fas fa-search"></i>
            </button>
            <div x-show="open" class="dashboard-mt-2">
                <form wire:submit.prevent="search" class="dashboard-form-inline" x-ref="searchForm">
                    <div class="dashboard-form-group dashboard-mb-2">
                        <input type="date" wire:model.defer="start_date" class="dashboard-form-control" placeholder="Start Date">
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2">
                        <input type="date" wire:model.defer="end_date" class="dashboard-form-control" placeholder="End Date">
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2">
                        <input type="text" wire:model.defer="category" class="dashboard-form-control" placeholder="Category">
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2">
                        <select wire:model.defer="type" class="dashboard-form-control">
                            <option value="">Income/Expense</option>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2">
                        <input type="text" wire:model.defer="description" class="dashboard-form-control" placeholder="Description">
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2">
                        <input type="number" step="0.01" wire:model.defer="amount" class="dashboard-form-control" placeholder="Amount">
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2">
                        <input type="text" wire:model.defer="banking_record" class="dashboard-form-control" placeholder="Banking Record">
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2">
                        <input type="text" wire:model.defer="payoff" class="dashboard-form-control" placeholder="Payoff">
                    </div>
                    <button type="submit" class="dashboard-btn dashboard-btn-primary dashboard-mb-2">Search</button>
                    <button type="button" wire:click="clear" class="dashboard-btn dashboard-btn-secondary dashboard-mb-2 dashboard-ml-2">Clear</button>
                </form>
            </div>

            <div class="dashboard-justify-center dashboard-flex dashboard-items-center dashboard-mt-4">
                @if ($transactions->isEmpty())
                    <p class="dashboard-text-center">No transactions found.</p>
                @else
                    <div class="dashboard-table-responsive">
                        <table class="dashboard-transaction-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Payoff</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->user_id }}</td>
                                        <td>{{ $transaction->date }}</td>
                                        <td><a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}">{{ $transaction->amount }} {{ $transaction->valuta }}</a></td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>{{ $transaction->type }}</td>
                                        <td>{{ $transaction->category_id }}</td>
                                        <td>{{ $transaction->payoff_id }}</td>
                                        <td>
                                            @if ($transaction->attachments->isNotEmpty())
                                                @foreach ($transaction->attachments as $attachment)
                                                    <a href="#modal-{{ $attachment->id }}">View Attachment</a>

                                                    <!-- Modal Structure -->
                                                    <div id="modal-{{ $attachment->id }}" class="dashboard-modal">
                                                        <div class="dashboard-modal-content">
                                                            <a href="#" class="dashboard-close">&times;</a>
                                                            <img src="{{ asset('storage/' . $attachment->picture) }}" alt="Attachment">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="dashboard-pagination dashboard-mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('renderGraph', function (categoryTotals, transactionData, balanceArr) {
            drawPie(categoryTotals);
            drawChart(transactionData, balanceArr);
        });
    });

    function clearFields() {
        const searchForm = document.querySelector('[x-ref=searchForm]');
        if (searchForm) {
            searchForm.reset();
        }
    }

    function drawPie(categoryTotals) {
        let data = new google.visualization.DataTable();
        data.addColumn('string', 'Category');
        data.addColumn('number', 'Amount');
        data.addRows(Object.entries(categoryTotals));

        let options = {
            title: 'Expenses by Category',
            pieHole: 0.2
        };

        let chart = new google.visualization.PieChart(document.getElementById('pieChart'));
        chart.draw(data, options);
    }

    function drawChart(transactionData, balanceArr) {
        let data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Single transaction');
        data.addColumn('number', 'Balance');

        let rows = [];
        let maxLength = Math.max(transactionData.length, balanceArr.length);

        for (let i = 0; i < maxLength; i++) {
            let transaction = transactionData[i] || {};
            let date = transaction.date || null;
            let transactionAmount = parseFloat(transaction.amount) || null;
            let balanceValue = parseFloat(balanceArr[i]) || null;
            rows.push([date, transactionAmount, balanceValue]);
        }

        data.addRows(rows);

        let options = {
            title: 'Transaction Trend and Balance',
            curveType: 'function',
            legend: { position: 'bottom' },
            series: {
                0: { color: '#1b9e77' },
                1: { color: '#d95f02' },
            }
        };

        let chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
