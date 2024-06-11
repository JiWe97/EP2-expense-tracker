@extends('layouts.custom')

@section('title', isset($transaction) ? 'Edit transaction' : 'Add transaction')

@section('styles')
  <style>
    .error {
      color: red;
      font-size: 0.8rem;
    }
  </style>
@endsection

@section('content')
  <form method="POST" 
    action="{{ isset($transaction) ? route('transactions.update', ['transaction' => $transaction->id]) : route('transactions.store') }}" 
    enctype="multipart/form-data">
    @csrf
    @if(isset($transaction))
        @method('PUT')
    @endif

    <div class="mb-4">
      <label for="action" class="block text-lg font-medium text-white">Type</label>
      <select class="form-control mt-1 block w-full text-black" id="action" name="type">
          <option value="">Select...</option>
          <option value="income" {{ isset($transaction) && $transaction->type == 'income' ? 'selected' : '' }}>Income</option>
          <option value="expense" {{ isset($transaction) && $transaction->type == 'expense' ? 'selected' : '' }}>Expense</option>
      </select>
    </div>

    <div class="mb-4">
      <label for="date">Date</label>
      <input type="date" name="date" id="date" @class(['border-red-500' => $errors->has('date')]) value="{{ old('date', isset($transaction) && $transaction->date ? $transaction->date : '') }}" />
      @error('date')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <label for="amount">Amount</label>
      <input type="number" name="amount" id="amount" @class(['border-red-500' => $errors->has('amount')]) value="{{ old('amount', isset($transaction) ? $transaction->amount : '') }}">
      @error('amount')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <input type="hidden" name="recipient_id" value="1">
      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
      <input type="hidden" name="valuta" value="EUR">
      <input type="hidden" name="exchange_rate" value="1.2">
    </div>

    <div class="mb-4">
      <label for="category" class="block text-lg font-medium text-white">Category:</label>
      <select class="form-control mt-1 block w-full text-black" id="category" name="category_id">
          <option value="">Select a category</option>
          @foreach ($combinedCategories as $category)
              <option value="{{ $category['id'] }}" {{ old('category_id', isset($transaction) && $transaction->category_id == $category['id'] ? 'selected' : '') }}>
                  {{ $category['name'] }}
              </option>
          @endforeach
      </select>
      @error('category')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <label for="description">Description</label>
      <textarea name="description" id="description" @class(['border-red-500' => $errors->has('description')])>{{ old('description', isset($transaction) ? $transaction->description : '') }}</textarea>
      @error('description')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <label for="banking_record_id">Bank Account</label>
      <select name="banking_record_id" id="banking_record_id" @class(['border-red-500' => $errors->has('banking_record_id')])>
          <option value="" disabled selected>Select a bank account</option>
          @foreach($bankingRecords as $record)
              <option value="{{ $record->id }}" {{ old('banking_record_id', isset($transaction) && $transaction->banking_record_id == $record->id ? 'selected' : '') }}>{{ $record->bank_name }}</option>
          @endforeach
      </select>
      @error('banking_record_id')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <label for="attachments" class="block text-lg font-medium text-white">Attachments:</label>
      <input type="file" multiple class="form-control mt-1 block w-full text-black" id="attachments" name="attachments[]">
    </div>

    <div class="flex items-center gap-2">
      <button type="submit" class="btn">
        @isset($transaction)
          Update Custom transactions
        @else
          Add Custom transactions
        @endisset
      </button>
      <a href="{{ route('transactions.index') }}" class="link">Cancel</a>
    </div>

    {{-- Error messages --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </form>
@endsection
