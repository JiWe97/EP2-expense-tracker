@extends('layouts.custom')

@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #e0e0e0;
        }

        .transaction-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .transaction-table th, .transaction-table td {
            border: none;
            padding: 12px 15px;
        }

        .transaction-table th {
            background-color: #f7f7f7;
            font-weight: bold;
            color: #333;
        }

        .transaction-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .transaction-table tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #555;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #333;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 1rem 0;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            color: #333;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .pagination .page-link:hover {
            background-color: #f1f1f1;
        }

        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-top: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
            width: 80%;
            max-width: 500px;
            margin: auto;
        }

        .modal img {
            max-width: 100%;
            height: auto;
        }

        .modal:target {
            display: flex;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
<div class="mb-4">
    <h1 class="text-2xl pt-5 font-bold">Current balance</h1>
    @foreach ($bankingRecords as $bankingRecord)
        <p>{{ $bankingRecord->name ?: $bankingRecord->bank_name }}: € {{ number_format($bankingRecord->balance, 2) }}</p>
        <p>Total saved: € {{ $totalAmountSaved }}</p>
        <p>Total without savings: € {{ $bankingRecord->balance - $totalAmountSaved }}</p>
    @endforeach
</div>

<div class="mb-4">
    <h1 class="text-2xl pt-5 font-bold">Manual Entry</h1>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-5">Add Transaction</a>
</div>

<div class="mb-4">
    <h1 class="text-2xl pt-5 font-bold">Upload Bank Statement</h1>
    <form action="{{ route('transactions.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".csv" class="form-control">
        <button class="btn btn-primary mt-2" type="submit">Upload</button>
    </form>
</div>

<div class="mb-4">
    <h2 class="text-2xl pt-5 font-bold">Transaction History</h2>

    @livewire('transaction-search')


    <div class="pagination mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
