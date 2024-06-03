@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold">Inkomsten</h1>
<div class="w-full h-full flex justify-center items-center">
        
        <div style="margin-left: 10px;">
                <form method="POST" action="{{ route('transactions.store') }}">
                    @csrf
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


                    <div class="mb-4" id="hidden-inputs">
                        <!-- Use ternary operators to set default values if $transaction does not exist -->
                        <input type="hidden" name="category_id" value="1">
                        <input type="hidden" name="user_id" value="1">
                        <input type="hidden" name="valuta" value="EUR">
                        <input type="hidden" name="exchange_rate" value="7">
                    </div>

                    <!-- Error handling remains unchanged -->

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
@endSection