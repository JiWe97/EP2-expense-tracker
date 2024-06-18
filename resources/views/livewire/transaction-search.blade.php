<div class="container">
    @section('style')
    <style>
        .btn-toggle-search {
                background-color: lightgrey;
                color: #333;
                border: 1px solid #ccc;
                font-size: 16px;
                padding: 10px 20px;
                border-radius: 5px;
                transition: background-color 0.3s, color 0.3s;
                display: inline-flex;
                align-items: center;
            }

            .btn-toggle-search i {
                margin-right: 8px;
                font-size: 18px;
            }

            .btn-toggle-search:hover {
                background-color: #bbb;
                color: #000;
                border-color: #aaa;
            }

            .btn-secondary {
                background-color: #f5f5f5;
                color: #333;
                border: 1px solid #ccc;
                font-size: 16px;
                padding: 10px 20px;
                border-radius: 5px;
                transition: background-color 0.3s, color 0.3s;
                display: inline-flex;
                align-items: center;
            }

            .btn-secondary i {
                margin-right: 8px;
                font-size: 18px;
            }

            .btn-secondary:hover {
                background-color: #ddd;
                color: #000;
                border-color: #bbb;
            }
        </style>
        @endsection

    <div class="mb-4" x-data="{ open: false }" @reset-search-form.window="clearFields()">
        <h2 class="text-2xl pt-5 font-bold">Search Transactions</h2>
    <button class="btn btn-toggle-search mb-2" @click="open = !open">
            <i class="fas fa-search"></i>
        </button>
    <div x-show="open" class="mt-2">
            <form wire:submit.prevent="search" class="form-inline" x-ref="searchForm">
                <div class="form-group mb-2">
                    <input type="date" wire:model.defer="start_date" class="form-control" placeholder="Start Date">
                </div>
                <div class="form-group mb-2">
                    <input type="date" wire:model.defer="end_date" class="form-control" placeholder="End Date">
                </div>
                <div class="form-group mb-2">
                    <input type="text" wire:model.defer="category" class="form-control" placeholder="Category">
                </div>
                <div class="form-group mb-2">
                    <select wire:model.defer="type" class="form-control">
                        <option value="">Income/Expense</option>
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <input type="text" wire:model.defer="description" class="form-control" placeholder="Description">
                </div>
                <div class="form-group mb-2">
                    <input type="number" step="0.01" wire:model.defer="amount" class="form-control" placeholder="Amount">
                </div>
                <div class="form-group mb-2">
                    <input type="text" wire:model.defer="banking_record" class="form-control" placeholder="Banking Record">
                </div>
                <div class="form-group mb-2">
                    <input type="text" wire:model.defer="payoff" class="form-control" placeholder="Payoff">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Search</button>
                <button type="button" wire:click="clear" class="btn btn-secondary mb-2 ml-2">Clear</button>
            </form>
        </div>

        <div class="justify-center flex items-center mt-4">
            @if ($transactions->isEmpty())
                <p class="text-center">No transactions found.</p>
            @else
                <div class="table-responsive">
                    <table class="transaction-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Bank</th>
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
                                    <td>{{ $transaction->category->name ?? 'N/A' }}</td>
                                    <td>{{ $transaction->banking_record_id }}</td>
                                    <td>{{ $transaction->payoff_id }}</td>
                                    <td>
                                        @if ($transaction->attachments->isNotEmpty())
                                            @foreach ($transaction->attachments as $attachment)
                                                <a href="#modal-{{ $attachment->id }}">View Attachment</a>

                                                <!-- Modal Structure -->
                                                <div id="modal-{{ $attachment->id }}" class="modal">
                                                    <div class="modal-content">
                                                        <a href="#" class="close">&times;</a>
                                                        <img src="{{ asset('storage/' . $attachment->picture) }}" alt="Attachment">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            No Attachment
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="pagination mt-4">
            {{ $transactions->links() }}
        </div>
    </div>

    <script>
        function clearFields() {
            const searchForm = document.querySelector('[x-ref=searchForm]');
            if (searchForm) {
                searchForm.reset();
            }
        }
    </script>
</div>
