<?php

namespace App\Http\Controllers;

use App\Models\BankingRecord;
use App\Models\Transaction;
use App\Models\Goal;
use App\Models\GoalTransaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $bankingRecords = BankingRecord::where('user_id', $userId)->get();
        $totalBalance = $bankingRecords->sum('balance');
        $goals = Goal::where('user_id', $userId)->get();
        $goalIds = $goals->pluck('id')->toArray();

        // Calculate total amount saved
        $totalAmountSaved = GoalTransaction::whereIn('goal_id', $goalIds)->sum('amount');

        // If there are no goals, set totalAmountSaved to 0
        if (empty($totalAmountSaved)) {
            $totalAmountSaved = 0;
        }

        $transactions = Transaction::with(['user', 'bankingRecord', 'category' => function ($query) {
            $query->withTrashed(); // Include soft-deleted categories
        }])
            ->where('user_id', $userId) // Filter transactions by the authenticated user's ID
            ->paginate(10);

        $query = Transaction::with(['bankingRecord', 'category'])->where('user_id', $userId);

        if ($request->has('selectedBankNames')) {
            $selectedBankNames = explode(',', $request->selectedBankNames);
            $query->whereHas('bankingRecord', function ($query) use ($selectedBankNames) {
                $query->whereIn('bank_name', $selectedBankNames);
            });
        }

        // Graph data logic
        $allTransactions = Transaction::with('category')->where('user_id', $userId)->get();

        // Filter and group expense transactions
        $expenseTransactions = $allTransactions->filter(function ($transaction) {
            return $transaction->type === 'expense';
        });

        $categoryTotals = $expenseTransactions->groupBy('category_id')->map(function ($categoryTransactions) {
            return $categoryTransactions->sum('amount') * -1;
        });

        // Pre-fetch categories to avoid multiple queries
        $categories = Category::whereIn('id', $categoryTotals->keys())->pluck('name', 'id');

        // Map category IDs to category names and keep the totals
        $categoryTotalsWithName = $categoryTotals->mapWithKeys(function ($total, $categoryId) use ($categories) {
            $name = $categories->get($categoryId, 'Unknown Category');
            return [$name => $total];
        });

        // Balance and transaction history
        $lastTransaction = Transaction::where('user_id', $userId)->latest()->first();
        $balance = BankingRecord::where('user_id', $userId)->latest()->first()->balance;
        $balanceArr = [];
        $transactionReverse = $allTransactions->reverse();
        foreach ($transactionReverse as $transaction) {
            $difference = $transaction->amount;
            $balance += $difference;
            $balanceArr[] = $balance;
        }
        $balanceArr = array_reverse($balanceArr);

        // Map transaction types for graph
        $transactionData = $allTransactions->map(function ($transaction) {
            return [
                'type' => $transaction->type,
                'amount' => $transaction->amount,
                'date' => $transaction->date,
            ];
        })->sortBy('date')->values()->toArray();

        // Return view with all necessary data
        return view('dashboard', [
            'transactions' => $transactions,
            'categories' => Category::all(),
            'bankingRecords' => $bankingRecords,
            'totalAmountSaved' => $totalAmountSaved,
            'totalBalance' => $totalBalance,
            'categoryTotals' => $categoryTotalsWithName,
            'transactionData' => $transactionData,
            'balanceArr' => $balanceArr
        ]);
    }
}
