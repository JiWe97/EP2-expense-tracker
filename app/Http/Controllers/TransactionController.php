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
use App\Models\Payoff;
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
        $userId = Auth::id();
        $bankingRecords = BankingRecord::where('user_id', $userId)->get();
        $goals = Goal::where('user_id', $userId)->get();
        $totalAmountSaved = GoalTransaction::whereIn('goal_id', $goals->pluck('id')->toArray())->sum('amount');

        $transactions = Transaction::with(['user', 'bankingRecord', 'category' => function($query) {
            $query->withTrashed(); // Include soft-deleted categories
        }])
        ->where('user_id', $userId) // Filter transactions by the authenticated user's ID
        ->paginate(10);

        return view('transactions.index', [
            'transactions' => $transactions,
            'categories' => Category::all(),
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
        $userId = Auth::id();
        $transactions = Transaction::where('user_id', $userId)->paginate(10); // Add pagination and filter by user_id
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
        $categories = Category::where('show', true)
            ->where('user_id', Auth::id())
            ->whereNull('deleted_at') // Exclude soft-deleted categories
            ->get();
        $bankingRecords = BankingRecord::where('user_id', Auth::id())->get();

        return view('transactions.edit', compact('transaction', 'categories', 'bankingRecords'));
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

        if ($transaction->payoff_id) {
            $this->updatePayoffBalanceOnDelete($transaction);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }

    private function updatePayoffBalanceOnDelete(Transaction $transaction)
    {
        $payoff = Payoff::find($transaction->payoff_id);
        if ($payoff) {
            // Switch the logic for removing the amount from the payoff balance
            if ($transaction->type === 'income') {
                $payoff->balance += abs($transaction->amount);
            } else {
                $payoff->balance -= abs($transaction->amount);
            }
            $payoff->save();

            \Log::info('Payoff balance updated on transaction delete:', [
                'id' => $payoff->id,
                'new_balance' => $payoff->balance,
            ]);
        }
    }

    public function search(Request $request)
    {
        $userId = Auth::id();
        $query = Transaction::with(['user', 'bankingRecord', 'category' => function($query) {
            $query->withTrashed(); // Include soft-deleted categories
        }])
        ->where('user_id', $userId); // Filter transactions by the authenticated user's ID

        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        if ($request->filled('amount')) {
            $query->where('amount', $request->amount);
        }

        if ($request->filled('banking_record')) {
            $query->whereHas('bankingRecord', function($q) use ($request) {
                $q->where('bank_name', 'like', '%' . $request->banking_record . '%');
            });
        }

        if ($request->filled('payoff')) {
            $query->whereHas('payoff', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->payoff . '%');
            });
        }

        return $query->paginate(10);
    }

}
