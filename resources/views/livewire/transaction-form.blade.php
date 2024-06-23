<div x-data="{ is_income: @js($is_income) }">
        <a href="{{ route('dashboard') }}" class="back-link">Back</a>
        <form wire:submit.prevent="saveOrUpdate">
            @csrf

            <div class="custom-form-group">
                <label for="action" class="text-lg font-medium text-white">Type</label>
                <div class="flex">
                    <button type="button" class="custom-btn custom-btn-income custom-btn-full" :class="is_income ? 'custom-bg-green-200' : 'custom-bg-gray-200'" @click="is_income = true; $wire.set('is_income', true)">Income</button>
                    <button type="button" class="custom-btn custom-btn-expense custom-btn-full ml-2" :class="!is_income ? 'custom-bg-red-200' : 'custom-bg-gray-200'" @click="is_income = false; $wire.set('is_income', false)">Expense</button>
                </div>
            </div>

            <div class="custom-form-group">
                <label for="date">Date</label>
                <input type="date" wire:model.lazy="date" id="date" class="custom-form-control @error('date') border-red-500 @enderror" />
                @error('date')
                    <p class="custom-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="custom-form-group">
                <label for="amount">Amount</label>
                <p class="text-sm">Don't use negative numbers, this happens automatically when needed!</p>
                <input type="number" wire:model.lazy="amount" min="0" step="0.01" id="amount" class="custom-form-control @error('amount') border-red-500 @enderror">
                @error('amount')
                    <p class="custom-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="custom-form-group">
                <label for="category" class="text-lg font-medium text-white">Category:</label>
                <select wire:model.lazy="category_id" id="category" class="custom-form-control">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="custom-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="custom-form-group">
                <label for="description">Description</label>
                <textarea wire:model.lazy="description" id="description" class="custom-form-control @error('description') border-red-500 @enderror"></textarea>
                @error('description')
                    <p class="custom-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="custom-form-group">
                <label for="banking_record_id">Bank Account</label>
                <select wire:model.lazy="banking_record_id" id="banking_record_id" class="custom-form-control @error('banking_record_id') border-red-500 @enderror">
                    <option value="">Select a bank account</option>
                    @foreach($bankingRecords as $record)
                        <option value="{{ $record->id }}">{{ $record->bank_name }}</option>
                    @endforeach
                </select>
                @error('banking_record_id')
                    <p class="custom-error">{{ $message }}</p>
                @enderror
            </div>
            
            @if($payoffs->isNotEmpty())
                <div class="custom-form-group">
                    <label for="payoff_id">Payoff</label>
                    <select wire:model.lazy="payoff_id" id="payoff_id" class="custom-form-control @error('payoff_id') border-red-500 @enderror">
                        <option value="">Select a payoff</option>
                        @foreach($payoffs as $payoff)
                            <option value="{{ $payoff->id }}">{{ $payoff->name }}</option>
                        @endforeach
                    </select>
                    @error('payoff_id')
                        <p class="custom-error">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div class="custom-form-group">
                <label for="attachments" class="text-lg font-medium text-white">Attachments:</label>
                <input type="file" multiple wire:model.lazy="attachments" id="attachments" class="custom-form-control">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="transaction-custom-btn">
                    @isset($transaction)
                        Update transaction
                    @else
                        Add transaction
                    @endisset
                </button>
                <a href="{{ route('dashboard') }}" class="transaction-custom-delete-btn">Cancel</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mt-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>

        @isset($transaction)
            <form action="{{ route('transactions.destroy', ['transaction' => $transaction->id]) }}" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="custom-btn custom-btn-danger">Delete</button>
            </form>
        @endisset
    </div>
</div>