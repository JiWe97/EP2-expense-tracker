<div>
    @push('styles')
        @include('layouts.styles')
    @endpush

    <div x-data="{ is_income: @entangle('is_income').defer }">
        <a href="{{ route('transactions.index') }}" class="link">Back</a>
        <form wire:submit.prevent="saveOrUpdate">
            @csrf

            <p>
                @if ($is_income)
                    <span class="text-green-500">Income</span>
                @else
                    <span class="text-red-500">Expense</span>
                @endif
                {{-- print category id --}}
                <span class="text-gray-500">Category id: {{ $category_id }}</span>
                <span class="text-gray-500">Type: {{ $type }}</span>
            </p>

            <div class="form-group">
                <label for="action" class="text-lg font-medium text-white">Type</label>
                <div class="flex">
                    <button type="button" class="btn btn-income btn-full {{ $is_income ? 'bg-green-200' : 'bg-gray-200'}}" @click="is_income = true; $wire.is_income = true">Income</button>
                    <button type="button" class="btn btn-expense btn-full ml-2 {{ $is_income ? 'bg-gray-200' : 'bg-red-200'}}" @click="is_income = false; $wire.is_income = false">Expense</button>
                </div>
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" wire:model.lazy="date" id="date" class="form-control @error('date') border-red-500 @enderror" />
                @error('date')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="amount">Amount</label>
                <p class="text-sm">Don't use negative numbers, this happens automatically when needed!</p>
                <input type="number" wire:model.lazy="amount" min="0" id="amount" class="form-control @error('amount') border-red-500 @enderror">
                @error('amount')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="category" class="text-lg font-medium text-white">Category:</label>
                <select wire:model.lazy="category_id" id="category" class="form-control">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea wire:model.lazy="description" id="description" class="form-control @error('description') border-red-500 @enderror"></textarea>
                @error('description')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="banking_record_id">Bank Account</label>
                <select wire:model.lazy="banking_record_id" id="banking_record_id" class="form-control @error('banking_record_id') border-red-500 @enderror">
                    <option value="">Select a bank account</option>
                    @foreach($bankingRecords as $record)
                        <option value="{{ $record->id }}">{{ $record->bank_name }}</option>
                    @endforeach
                </select>
                @error('banking_record_id')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="attachments" class="text-lg font-medium text-white">Attachments:</label>
                <input type="file" multiple wire:model.lazy="attachments" id="attachments" class="form-control">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="btn">
                    @isset($transaction)
                        Update transaction
                    @else
                        Add transaction
                    @endisset
                </button>
                <a href="{{ route('transactions.index') }}" class="btn">Cancel</a>
            </div>

            {{-- Error messages --}}
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
            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        @endisset
    </div>
</div>
