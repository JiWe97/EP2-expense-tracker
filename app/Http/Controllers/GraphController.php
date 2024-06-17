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

        //Aggregate data by category and calculate total amount for each category
        // $categoryTotals = $transactions->groupBy('category_id')->map(function ($categoryTransactions) {
        //     return $categoryTransactions->sum('amount');
        // });

        // $categoryTotalsWithName = $categoryTotals->mapWithKeys(function ($total, $categoryId) {
        //     $name = Category::find($categoryId)->name;
        //     return [$name => $total];
        // });

        $expenseTransactions = $transactions->filter(function ($transaction) {
            return $transaction->type === 'expense';
        });

        // Group filtered transactions by 'category_id' and sum the 'amount'
        $categoryTotals = $expenseTransactions->groupBy('category_id')->map(function ($categoryTransactions) {
            return $categoryTransactions->sum('amount')*-1;
        });

        // Pre-fetch categories to avoid multiple queries
        $categories = Category::whereIn('id', $categoryTotals->keys())->pluck('name', 'id');

        // Map category IDs to category names and keep the totals
        $categoryTotalsWithName = $categoryTotals->mapWithKeys(function ($total, $categoryId) use ($categories) {
            $name = $categories->get($categoryId, 'Unknown Category');
            return [$name => $total];
        });



        // print_r($categoryTotals);


        // Map transaction types
        $transactionData = $transactions->map(function ($transaction) {
            return [
                'type' => $transaction->type,
                'amount' => $transaction->amount,
                'date' => $transaction->date,
            ];
        })->sortBy('date')->values()->toArray(); // Sort by date and reset keys
        // print_r($transactionData);

        return view('graph', ['categoryTotals' => $categoryTotalsWithName, 'transactionData' => $transactionData]);
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
