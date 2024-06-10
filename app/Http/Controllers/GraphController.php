<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $transactions = Transaction::with('category')->get();

    // Aggregate data by category and calculate total amount for each category
    $categoryTotals = $transactions->groupBy('category_id')->map(function ($categoryTransactions) {
        return $categoryTransactions->sum('amount');
    });

    // Map transaction types
    $transactionData = $transactions->map(function ($transaction) {
        return [
            'type' => $transaction->type,
            'amount' => $transaction->amount,
        ];
    });
    // print_r($transactionData);

    return view('graph', ['categoryTotals' => $categoryTotals, 'transactionData' => $transactionData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
