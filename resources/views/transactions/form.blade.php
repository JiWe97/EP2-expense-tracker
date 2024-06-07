@extends('layouts.custom')

@section('title', isset($transaction)? 'Edit transaction' : 'Add transaction')

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
    action="{{ isset($transactions)? route('transactions.update', ['transactions' => $transactions->id]) : route('transactions.store') }}">
    @csrf
    @if(isset($transactions))
        @method('PUT')
    @endif

    <div class="mb-4">
        <label for="action" class="block text-lg font-medium text-white">Type</label>
        <select class="form-control mt-1 block w-full text-black" id="action" name="type">
            <option value="">Select...</option>
            <option value="income">Income</option>
            <option value="expense">Expense</option>
        </select>
    </div>

    <div class="mb-4">
      <label for="date">Date</label>
      <input type="date" name="date" id="date" @class(['border-red-500' => $errors->has('date')]) value="{{ $transactions->date?? old('date') }}" />
      @error('date')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
        <label for="amount">Amount</label>
        <input type="number" name="amount" id="amount" @class(['border-red-500' => $errors->has('amount')]) value="{{ $transactions->amount?? old('amount') }}">
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
        <label for="category">Category</label>
        <select name="category" id="category" @class(['border-red-500' => $errors->has('category')]):
            @error('category')
                <option value="">Select a category</option>
            @enderror
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
                </select>
        @error('category')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="description">Description</label>
        <textarea type="text" name="description" id="description" @class(['border-red-500' => $errors->has('description')]) value="{{ $transactions->description?? old('description') }}"></textarea>
        @error('description')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
          <label for="banking_record_id">Bank Account</label>
          <select name="banking_record_id" id="banking_record_id" @class(['border-red-500' => $errors->has('banking_record_id')])>
              <option value="" disabled selected>Select a bank account</option>
              @foreach($banking_records as $record)
                  <option value="{{ $transactions->banking_record_id }}" {{ (isset($budget) && $record->id == $budget->banking_record_id) ? 'selected' : '' }}>{{ $record->bank_name }}</option>
              @endforeach
          </select>
          @error('banking_record_id')
              <p class="error">{{ $message }}</p>
          @enderror
      </div>

    <div class="flex items-center gap-2">
      <button type="submit" class="btn">
        @isset($transactions)
          Update Custom transactions
        @else
          Add Custom transactions
        @endisset
      </button>
      <a href="{{ route('transactions.index') }}" class="link">Cancel</a>
    </div>
    {{-- errormessage --}}
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
