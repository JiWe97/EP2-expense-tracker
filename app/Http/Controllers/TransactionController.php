<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all(); // Fetch categories
        return view('transactions.index', ['transactions' => Transaction::all(), 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch categories from the database
        $categories = Category::all();
        
        // Pass categories to the view
        return view('transactions.create', ['categories' => $categories]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $transaction = Transaction::create([
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'recipient_id' => $request->recipient_id, // Ensure this is provided
            'banking_record_id' => $request->banking_record_id,
            'type' => $request->type,
        ]);
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $transactions = Transaction::paginate(10); // Add pagination
        return view('transactions.show', compact('transactions'));
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

    // public function toggle(Transaction $transaction)
    // {
    //     $transaction->toggleShow();
    //     return redirect()->back()->with('success', 'Show history updated successfully');
    // }
}
