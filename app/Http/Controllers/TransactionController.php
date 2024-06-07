<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BankingRecord;
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
        $categories = Category::all();
        $transactions = Transaction::paginate(10); // Add pagination

        if(request()->has('search')){
            $query = request()->get('search','');
            $transactions = Transaction::with(['user', 'bankingRecord'])
            ->where('amount', 'LIKE', "{$query}")
            ->orWhere('custom_category_id', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('type', 'LIKE', "{$query}")
            ->orWhere('valuta', 'LIKE', "{$query}")
            ->orWhere('exchange_rate', 'LIKE', "{$query}")
            ->orWhere('warranty', 'LIKE', "{$query}")
            ->orWhere('warranty_date', 'LIKE', "{$query}")
            ->orWhere('created_at', 'LIKE', "{$query}")
            ->orWhere('updated_at', 'LIKE', "{$query}")
            ->orWhere('recipient_id', 'LIKE', "%{$query}%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('bankingRecord', function ($q) use ($query) {
                $q->where('bank_name', 'LIKE', "%{$query}%"); // Assuming banking records have a 'record_name' column
            })
            ->paginate(10);
            
        }

        // dd($transactions);
        foreach ($transactions as $transaction) {
            $id = $transaction->user_id;
            $user = User::find($id);
            $transaction->user_id = $user->name;


            $id = $transaction->banking_record_id;
            $bankingRecord = BankingRecord::find($id);
            $transaction->banking_record_id = $bankingRecord->bank_name;
            // $transaction->bankingRecord ? $transaction->bankingRecord->record_name : null = $transaction->bankingRecord ? $transaction->bankingRecord->record_name : null;
        }
        
        return view('transactions.index', ['transactions' => $transactions, 'categories' => $categories]);
        
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
