<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BankingRecord;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Attachment;
use App\Models\Goal;
use App\Models\GoalTransaction;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bankingRecords = BankingRecord::where('user_id', Auth::user()->id)->get();
        $goals = Goal::where('user_id', Auth::user()->id)->get();
        $totalAmountSaved = GoalTransaction::whereIn('goal_id', $goals->pluck('id')->toArray())->sum('amount');
        $categories = Category::all();
        $transactions = Transaction::with(['user', 'bankingRecord']);

        if (request()->has('search')) {
            $query = request()->get('search', '');
            print_r($query);
            $transactions->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('amount', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('type', 'LIKE', "%{$query}%")
                    ->orWhere('valuta', 'LIKE', "%{$query}%")
                    ->orWhere('date', 'LIKE', "%{$query}%")
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
            $monthsOfYear = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            if (in_array($query, $monthsOfYear)) {
                $monthIndex = array_search($query, $monthsOfYear) + 1;
                $formattedMonth = sprintf('%02d', $monthIndex); // Ensure the month is two digits
                $transactions->where('date', 'LIKE', "%.{$formattedMonth}.%");
            }
        }

        $transactions = $transactions->paginate(10);

        $transactions->each(function ($transaction) {
            $transaction->user_id = User::find($transaction->user_id)->name;
            $transaction->banking_record_id = BankingRecord::find($transaction->banking_record_id)->bank_name;
            $transaction->category_id = Category::find($transaction->category_id)->name;
        });


        return view('transactions.index', [
            // 'query' => request()->get('search', ''),
            'transactions' => $transactions,
            'categories' => $categories,
            'bankingRecords' => $bankingRecords,
            'totalAmountSaved' => $totalAmountSaved
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('show', true)
            ->where('user_id', Auth::id())
            ->get();
        $bankingRecords = BankingRecord::where('user_id', Auth::id())->get();

        return view('transactions.create', compact('categories', 'bankingRecords'));
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
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\View\View
     */
    public function edit(Transaction $transaction)
    {
        $bankingRecords = BankingRecord::all();
        $categories = Category::where('show', true)
            ->where('user_id', Auth::id())
            ->get();

        return view('transactions.edit', compact('transaction', 'bankingRecords', 'categories'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Transaction $transaction)
    {
        $bankingRecord = BankingRecord::find($transaction->banking_record_id);
        if ($bankingRecord) {
            $bankingRecord->balance -= $transaction->amount;
            $bankingRecord->save();

            \Log::info('Transaction amount reverted:', [
                'id' => $bankingRecord->id,
                'new_balance' => $bankingRecord->balance,
            ]);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
