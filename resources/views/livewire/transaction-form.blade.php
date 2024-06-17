<div>
    <style>
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            color: black;
            text-align: center;
            text-decoration: none;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-full {
            width: 100%;
            background-color: #f0f0f0;
        }

        .bg-green-200 {
            background-color: rgba(144, 238, 144, 0.8); /* LightGreen with 80% opacity */
        }

        .btn-income:hover {
            background-color: rgba(144, 238, 144, 1);
        }

        .bg-red-200 {
            background-color: rgba(255, 99, 71, 0.8); /* Tomato with 80% opacity */
        }

        .btn-expense:hover {
            background-color: rgba(255, 99, 71, 1);
        }

        .bg-gray-200 {
            background-color: rgba(211, 211, 211, 0.5); /* LightGray with 50% opacity */
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .error {
            color: red;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }

        .form-group textarea {
            height: 150px;
        }

        .form-group select {
            height: 50px;
        }
    </style>

    <div x-data="{ is_income: @js($is_income) }">
        <a href="{{ route('transactions.index') }}" class="link">Back</a>
        <form wire:submit.prevent="saveOrUpdate">
            @csrf
            <p>
                <span x-show="is_income" class="text-green-500">Income</span>
                <span x-show="!is_income" class="text-red-500">Expense</span>
                <span class="text-gray-500">Category id: {{ $category_id }}</span>
                <span class="text-gray-500">Type: {{ $type }}</span>
            </p>

            <div class="form-group">
                <label for="action" class="text-lg font-medium text-white">Type</label>
                <div class="flex">
                    <button type="button" class="btn btn-income btn-full" :class="is_income ? 'bg-green-200' : 'bg-gray-200'" @click="is_income = true; $wire.set('is_income', true)">Income</button>
                    <button type="button" class="btn btn-expense btn-full ml-2" :class="!is_income ? 'bg-red-200' : 'bg-gray-200'" @click="is_income = false; $wire.set('is_income', false)">Expense</button>
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
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        @endisset
    </div>
</div>