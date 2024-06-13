<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BankingRecord;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CustomCategory;
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $categories = Category::all();
            
            $transactions = Transaction::with(['user', 'bankingRecord']);
            
              
            
            // Check if search query is present
            
            if(request()->has('search')){
                $query = request()->get('search', '');
                // Search for transactions based on various fields
                $transactions->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('amount', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('type', 'LIKE', "%{$query}%")
                ->orWhere('valuta', 'LIKE', "%{$query}%")
                ->orWhere('exchange_rate', 'LIKE', "%{$query}%")
                ->orWhere('warranty', 'LIKE', "%{$query}%")
                ->orWhere('warranty_date', 'LIKE', "%{$query}%")
                ->orWhere('created_at', 'LIKE', "%{$query}%")
                ->orWhere('updated_at', 'LIKE', "%{$query}%")
                ->orWhere('recipient_id', 'LIKE', "%{$query}%")
                ->orWhereHas('category', function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                ->orWhereHas('user', function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                ->orWhereHas('bankingRecord', function ($q) use ($query) {
                    $q->where('bank_name', 'LIKE', "%{$query}%");
                });
                });
            
              
            
                // Attempt to parse the query as a date
                $dateFormats = ['d-m', 'd/m', 'd-m-Y', 'd/m/Y', 'Y-m-d'];
                $monthsOfYear = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            
              
                foreach ($dateFormats as $format) {
                    $date = DateTime::createFromFormat($format, $query);
                    if ($date && $date->format($format) === $query) {
                    // If the query matches a valid date format
                    $year = $date->format('Y');
                    $month = $date->format('m');
                    $day = $date->format('d');
                    // Filter transactions by month
            
                    $transactions->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->orWhereYear('updated_at', $year)
                    ->whereMonth('updated_at', $month)
                    ->orWhereDay('created_at', $day)
                    ->orWhereDay('updated_at', $day);
                    break;
                    }
            
                }
            
              
            
                // Check if the query is a month name
            
                if (in_array($query, $monthsOfYear)) 
                {
                    $monthIndex = array_search($query, $monthsOfYear) + 1; // Get month index (1-based)
                    // Filter transactions by month
                    $transactions->whereMonth('created_at', $monthIndex)
                    ->orWhereMonth('updated_at', $monthIndex);
                }
            
            }
            
              
            
            // Paginate the results
            
            $transactions = $transactions->paginate(10);
            
              
            
            // Replace IDs with corresponding names
            
            $transactions->each(function ($transaction) {
                $transaction->user_id = User::find($transaction->user_id)->name;
                $transaction->banking_record_id = BankingRecord::find($transaction->banking_record_id)->bank_name;
                $transaction->category_id = Category::find($transaction->category_id)->name;
            });
            
              
            
        return view('transactions.index', ['transactions' => $transactions, 'categories' => $categories]);
            
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('show', true)->get();  // Filter categories based on 'show' attribute
        $custom_categories = CustomCategory::where('user_id', Auth::id())->get();

        // Create a combined list where custom category display names override the category names
        $combinedCategories = [];
        foreach ($categories as $category) {
            $customCategory = $custom_categories->firstWhere('category_id', $category->id);
            $combinedCategories[] = [
                'id' => $category->id,
                'name' => $customCategory ? $customCategory->displayname : $category->name,
            ];
        }

        return view('transactions.create', compact('combinedCategories'));
    }



    /**
     * Store a newly created resource in storage.
     */   

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'banking_record_id' => 'required|integer',
            'category_id' => 'required|integer',
            'recipient_id' => 'required|integer',
            'attachments.*' => 'file|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Save the transaction
        $transaction = new Transaction();
        $transaction->type = $request->type;
        $transaction->amount = $request->amount;
        $transaction->description = $request->description;
        $transaction->banking_record_id = $request->banking_record_id;
        $transaction->category_id = $request->category_id;
        $transaction->recipient_id = $request->recipient_id;
        $transaction->user_id = $request->user_id;
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
