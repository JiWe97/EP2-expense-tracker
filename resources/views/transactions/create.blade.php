@extends('layouts.custom')

@section('content')
<div class="w-full h-full flex justify-center items-center">
    <div style="margin-left: 10px;">
        <form method="POST" action="{{ route('transactions.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Existing form fields -->
            <div class="mb-4">
                <label for="action" class="block text-lg font-medium text-white">Type</label>
                <select class="form-control mt-1 block w-full text-black" id="action" name="type">
                    <option value="">Select...</option>
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-lg font-medium text-white">Amount:</label>
                <input type="number" step="0.01" class="form-control mt-1 block w-full text-black" id="amount" name="amount" placeholder="Amount">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-white">Description:</label>
                <input type="text" class="form-control mt-1 block w-full text-black" id="description" name="description" placeholder="Description">
            </div>
            <div class="mb-4">
                <label for="banking_record_id" class="block text-lg font-medium text-white">Banking Record ID:</label>
                <input type="number" class="form-control mt-1 block w-full text-black" id="banking_record_id" name="banking_record_id" placeholder="Banking Record ID">
            </div>
            <div class="mb-4">
                <label for="category" class="block text-lg font-medium text-white">Category:</label>
                <select class="form-control mt-1 block w-full text-black" id="category" name="category_id">
                    <option value="">Select a category</option>
                    @foreach ($combinedCategories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="recipient_id" class="block text-lg font-medium text-white">Recipient ID:</label>
                <input type="number" class="form-control mt-1 block w-full text-black" id="recipient_id" name="recipient_id" placeholder="Recipient ID">
            </div>
            <!-- File upload field -->
            <div class="mb-4">
                <label for="attachments" class="block text-lg font-medium text-white">Attachments:</label>
                <input type="file" multiple class="form-control mt-1 block w-full text-black" id="attachments" name="attachments[]">
            </div>
            <div class="mb-4" id="hidden-inputs">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="valuta" value="EUR">
                <input type="hidden" name="exchange_rate" value="7">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Submit
            </button>
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
    </div>
</div>
@endsection
