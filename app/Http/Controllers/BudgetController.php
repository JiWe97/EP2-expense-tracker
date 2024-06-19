<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Http\Requests\BudgetRequest;
use App\Models\BankingRecord;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $userBankingRecordIds = BankingRecord::where('user_id', $userId)->pluck('id');
        
        $budgets = Budget::with(['bankingRecord', 'categories'])
            ->whereHas('bankingRecord', function ($query) use ($userBankingRecordIds) {
                $query->whereIn('id', $userBankingRecordIds);
            })
            ->get();
        
        // Calculate the balance for each budget
        foreach ($budgets as $budget) {
            $budget->balance = Transaction::whereIn('category_id', $budget->categories->pluck('id'))->sum('amount');
            $budget->balance = abs($budget->balance);  // Ensure balance is treated as positive
        }

        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        $categories = Category::visibleToUser()->get();
        $banking_records = BankingRecord::all();

        return view('budgets.form', compact('categories', 'banking_records'));
    }

    public function store(BudgetRequest $request)
    {
        Budget::validateAndCreate($request);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget created successfully');
    }

    public function show($budgetId)
    {
        $budget = Budget::with('categories')->findOrFail($budgetId);
        $categoryIds = $budget->categories->pluck('categories.id')->toArray(); // Specify table name

        $transactions = Transaction::where('type', 'expense')
            ->whereIn('category_id', $categoryIds)
            ->get()
            ->map(function ($transaction) {
                $transaction->amount = abs($transaction->amount);
                return $transaction;
            });

        $banking_records = BankingRecord::all();

        return view('budgets.show', compact('budget', 'transactions', 'banking_records'));
    }

    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        $categories = Category::visibleToUser()->get();
        $banking_records = BankingRecord::all();

        return view('budgets.form', compact('budget', 'categories', 'banking_records'));
    }

    public function update(BudgetRequest $request, Budget $budget)
    {
        $budget->updateAndSyncCategories($request);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget updated successfully');
    }

    public function destroy(Budget $budget)
    {
        $budget->categories()->detach();
        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully');
    }

    public function history(Request $request, $budgetId)
    {
        // Find the budget and get associated category IDs
        $budget = Budget::findOrFail($budgetId);
        $categoryIds = $budget->categories()->pluck('categories.id')->toArray(); // Specify table name
    
        // Build the query to aggregate transactions by year and month
        $query = Transaction::selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(ABS(amount)) as total_amount')
            ->whereIn('category_id', $categoryIds)
            ->groupBy('year, month');
    
        // Apply year filter if provided
        if ($year = $request->input('year')) {
            $query->whereYear('date', $year);
        }
    
        // Apply month filter if provided
        if ($month = $request->input('month')) {
            $query->whereMonth('date', $month);
        }
    
        // Execute the query and map the results
        $transactions = $query->get()->map(function ($transaction) use ($budget) {
            $transaction->remaining_amount = $budget->amount - $transaction->total_amount;
            $transaction->month_name = \Carbon\Carbon::create()->month($transaction->month)->format('F');
            return $transaction;
        });
    
        // Sort transactions by amount spent if requested
        if ($sortSpent = $request->input('sort_spent')) {
            $transactions = $sortSpent === 'highest' ? $transactions->sortByDesc('total_amount') : $transactions->sortBy('total_amount');
        }
    
        // Sort transactions by amount remaining if requested
        if ($sortRemaining = $request->input('sort_remaining')) {
            $transactions = $sortRemaining === 'highest' ? $transactions->sortByDesc('remaining_amount') : $transactions->sortBy('remaining_amount');
        }
    
        // Debugging: Log the transactions to check if they are being retrieved correctly
        \Log::info('Transactions retrieved for history:', $transactions->toArray());
    
        // Render the view with the budget and transactions
        return view('budgets.history', compact('budget', 'transactions', 'year, month', 'sortSpent', 'sortRemaining'));
    }
}
