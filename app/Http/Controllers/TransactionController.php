<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BankingRecord;
use App\Models\Transaction;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BankStatementsImport; 
use Illuminate\Support\Facades\Log;

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
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('date', 'LIKE', "{$query}")
            ->orWhere('type', 'LIKE', "{$query}")
            ->orWhere('valuta', 'LIKE', "{$query}")
            ->orWhere('exchange_rate', 'LIKE', "{$query}")
            ->orWhere('warranty', 'LIKE', "{$query}")
            ->orWhere('warranty_date', 'LIKE', "{$query}")
            ->orWhere('created_at', 'LIKE', "{$query}")
            ->orWhere('updated_at', 'LIKE', "{$query}")
            ->orWhereHas('category', function ($q) use ($query){
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('bankingRecord', function ($q) use ($query) {
                $q->where('bank_name', 'LIKE', "%{$query}%");
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

            $id = $transaction->category_id;
            $category = Category::find($id);
            $transaction->category_id = $category->name;
        }
        
        return view('transactions.index', ['transactions' => $transactions, 'categories' => $categories]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('show', true)->where('user_id', Auth::id())->get();
        $bankingRecords = BankingRecord::all();  // Add this line to fetch banking records

        return view('transactions.create', compact('categories', 'bankingRecords'));
    }

    /**
     * Store a newly created resource in storage.
     */   
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'banking_record_id' => 'required|integer',
            'category_id' => 'required|integer',
            'attachments.*' => 'file|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Save the transaction
        $transaction = new Transaction();
        $transaction->type = $request->type;
        $transaction->date = $request->date;
        $transaction->amount = $request->amount;
        $transaction->description = $request->description;
        $transaction->banking_record_id = $request->banking_record_id;
        $transaction->category_id = $request->category_id;
        $transaction->user_id = Auth::id(); // Set the user_id to the authenticated user
        $transaction->valuta = $request->valuta;
        $transaction->exchange_rate = $request->exchange_rate;
        $transaction->save();

        // Save attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments');

                $attachment = new Attachment();
                $attachment->picture = $path;
                $attachment->transaction_id = $transaction->id;
                $attachment->save();
            }
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
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
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $bankingRecords = BankingRecord::all();
        $categories = Category::where('show', true)->where('user_id', Auth::id())->get();

        return view('transactions.edit', compact('transaction', 'bankingRecords', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'banking_record_id' => 'required|integer',
            'category_id' => 'required|integer',
            'attachments.*' => 'file|mimes:jpeg,png,jpg|max:2048',
        ]);

        $transaction = Transaction::findOrFail($id);

        $transaction->type = $request->type;
        $transaction->amount = $request->amount;
        $transaction->description = $request->description;
        $transaction->date = $request->date;
        $transaction->banking_record_id = $request->banking_record_id;
        $transaction->category_id = $request->category_id;
        $transaction->user_id = $request->user_id; // Set the budget_id
        $transaction->valuta = $request->valuta;
        $transaction->exchange_rate = $request->exchange_rate;
        $transaction->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments');

                $attachment = new Attachment();
                $attachment->picture = $path;
                $attachment->transaction_id = $transaction->id;
                $attachment->save();
            }
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }

    public function import(TransactionRequest $request) 
    {
        if ($request->hasFile('file')) {
            try {
                // Log file upload start
                Log::info('File upload started');

                Excel::import(new BankStatementsImport, $request->file('file'));

                // Log file upload success
                Log::info('File upload completed successfully');

                return redirect()->route('transactions.index', ['transactions' => Transaction::paginate(10)])->with('success', 'Transactions imported successfully.');
            } catch (Exception $ex) {
                // Log exception
                Log::error('File import error: ' . $ex->getMessage());
                Log::error($ex->getTraceAsString());

                return response()->json(['data' => 'Some error has occurred.', 'message' => $ex->getMessage()], 400);
            }
        } else {
            // Log no file error
            Log::error('No file was uploaded');

            return redirect()->route('transactions.index', ['transactions' => Transaction::paginate(10)])->with('error', 'No file uploaded.');
        }
    }
}
