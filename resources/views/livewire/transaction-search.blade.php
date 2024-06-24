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
        <!-- Chart components -->
        <div class="dashboard-mt-4">
            @livewire('line-chart', ['labels' => $chartData['labels'], 'income' => $chartData['income'], 'expense' => $chartData['expense'], 'balance' => $chartData['balance']])
        </div>
        <div class="dashboard-mt-4">
            @livewire('pie-chart', ['categoryData' => $chartData['categories']])
        </div>

        <!-- Search components -->
        <div class="dashboard-mb-4" x-data="{ open: false }" @reset-search-form.window="clearFields()">
            <button class="search-btn" @click="open = !open">
                <i class="fas fa-search"></i>
            </button>
            <div x-show="open" class="dashboard-mt-2">
                <form wire:submit.prevent="search" class="dashboard-form-inline" x-ref="searchForm">
                    <div class="dashboard-form-group dashboard-mb-2">
                        <label for="start_date">Start Date</label>
                        <input type="date" wire:model.defer="start_date" class="dashboard-form-control" placeholder="Start Date">
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2 dashboard-ml-2">
                        <label for="end_date">End Date</label>
                        <input type="date" wire:model.defer="end_date" class="dashboard-form-control" placeholder="End Date">
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2 dashboard-ml-2">
                        <label for="category">Category</label>
                        <select wire:model.defer="category" class="dashboard-form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2 dashboard-ml-2">
                        <label for="type">Type</label>
                        <select wire:model.defer="type" class="dashboard-form-control">
                            <option value="">Income/Expense</option>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2 dashboard-ml-2">
                        <label for="description">Description</label>
                        <input type="text" wire:model.defer="description" class="dashboard-form-control" placeholder="Description">
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2 dashboard-ml-2">
                        <label for="amount">Amount</label>
                        <input type="number" step="0.01" wire:model.defer="amount" class="dashboard-form-control" placeholder="Amount">
                    </div>
                    <div class="dashboard-form-group dashboard-mb-2 dashboard-ml-2">
                        <label for="payoff">Payoff</label>
                        <input type="text" wire:model.defer="payoff" class="dashboard-form-control" placeholder="Payoff">
                    </div>
                </form>
                <div class="dashboard-mt-2">
                    <button type="submit" class="edit-custom-btn">Search</button>
                    <button type="button" wire:click="clear" class="clear-custom-btn dashboard-ml-2">Clear</button>
                </div>
            </div>

            <div class="dashboard-justify-center dashboard-flex dashboard-items-center dashboard-mt-4">
                @if ($transactions->isEmpty())
                    <p class="dashboard-text-center">No transactions found.</p>
                @else
                    <div class="dashboard-table-responsive">
                        <table class="dashboard-transaction-table">
                            <thead>
                                <tr>
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
                                        <td>{{ $transaction->date }}</td>
                                        <td><a href="{{ route('transactions.edit', ['transaction' => $transaction->id]) }}">{{ $transaction->amount }} {{ $transaction->valuta }}</a></td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>{{ $transaction->type }}</td>
                                        <td>{{ $transaction->category->name ?? 'N/A' }}</td>
                                        <td>{{ $transaction->payoff->name ?? '' }}</td>
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

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
</script>
