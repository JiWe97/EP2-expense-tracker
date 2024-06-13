@extends('layouts.custom')

@section('title', isset($transaction) ? 'Edit transaction' : 'Add transaction')

@section('styles')
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
      height: 40px;
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

    <div class="form-group">
      <label for="action" class="text-lg font-medium text-white">Type</label>
      <select class="form-control" id="action" name="type">
          <option value="">Select...</option>
          <option value="income" {{ old('type', isset($transaction) && $transaction->type == 'income' ? 'selected' : '') }}>Income</option>
          <option value="expense" {{ old('type', isset($transaction) && $transaction->type == 'expense' ? 'selected' : '') }}>Expense</option>
      </select>
    </div>

    <div class="form-group">
      <label for="date">Date</label>
      <input type="date" name="date" id="date" class="form-control @error('date') border-red-500 @enderror" value="{{ old('date', isset($transaction) ? $transaction->date : '') }}" />
      @error('date')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="form-group">
      <label for="amount">Amount</label>
      <input type="number" name="amount" id="amount" class="form-control @error('amount') border-red-500 @enderror" value="{{ old('amount', isset($transaction) ? $transaction->amount : '') }}">
      @error('amount')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="form-group">
      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
      <input type="hidden" name="valuta" value="EUR">
      <input type="hidden" name="exchange_rate" value="1.2">
    </div>

    <div class="form-group">
      <label for="category" class="text-lg font-medium text-white">Category:</label>
      <select class="form-control" id="category" name="category_id">
          <option value="">Select a category</option>
          @foreach ($categories as $category)
              <option value="{{ $category['id'] }}" {{ old('category_id', isset($transaction) && $transaction->category_id == $category['id'] ? 'selected' : '') }}>
                  {{ $category['name'] }}
              </option>
          @endforeach
      </select>
      @error('category')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <textarea name="description" id="description" class="form-control @error('description') border-red-500 @enderror">{{ old('description', isset($transaction) ? $transaction->description : '') }}</textarea>
      @error('description')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="form-group">
      <label for="banking_record_id">Bank Account</label>
      <select name="banking_record_id" id="banking_record_id" class="form-control @error('banking_record_id') border-red-500 @enderror">
          <option value="" disabled selected>Select a bank account</option>
          @foreach($bankingRecords as $record)
              <option value="{{ $record->id }}" {{ old('banking_record_id', isset($transaction) && $transaction->banking_record_id == $record->id ? 'selected' : '') }}>{{ $record->bank_name }}</option>
          @endforeach
      </select>
      @error('banking_record_id')
        <p class="error">{{ $message }}</p>
      @enderror
    </div>

    <div class="form-group">
      <label for="attachments" class="text-lg font-medium text-white">Attachments:</label>
      <input type="file" multiple class="form-control" id="attachments" name="attachments[]">
    </div>

    <div class="flex items-center gap-2">
      <button type="submit" class="btn">
        @isset($transaction)
          Update Custom transactions
        @else
          Add Custom transactions
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
@endsection
