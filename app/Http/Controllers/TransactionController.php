<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::paginate(10); // Add pagination
        

        if(request()->has('search')){
            $query = request()->get('search','');
            $transactions = Transaction::where('amount', 'LIKE', "%{$query}%")
                ->orWhere('custom_category_id', 'LIKE', "%{$query}%")
                ->orWhere('user_id', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('type', 'LIKE', "%{$query}%")
                ->orWhere('valuta', 'LIKE', "%{$query}%")
                ->orWhere('recipient_id', 'LIKE', "%{$query}%")
                ->orWhere('exchange_rate', 'LIKE', "%{$query}%")
                ->orWhere('warranty', 'LIKE', "%{$query}%")
                ->orWhere('warranty_date', 'LIKE', "%{$query}%")
                ->orWhere('banking_record_id', 'LIKE', "%{$query}%")
                ->orWhere('created_at', 'LIKE', "%{$query}%")
                ->orWhere('updated_at', 'LIKE', "%{$query}%")
                ->paginate(10);
        }

        return view('history', [
            'transactions' => $transactions
        ]);
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
