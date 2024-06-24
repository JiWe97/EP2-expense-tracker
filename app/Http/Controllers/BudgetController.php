<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\BankingRecord;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\BudgetRequest;

class BudgetController extends Controller
{
    /**
     * Display a listing of the budgets.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userId = Auth::id();
        $userBankingRecordIds = BankingRecord::where('user_id', $userId)->pluck('id');

        $budgets = Budget::with(['bankingRecord', 'categories'])
            ->whereHas('bankingRecord', function ($query) use ($userBankingRecordIds) {
                $query->whereIn('id', $userBankingRecordIds);
            })
            ->get();

        foreach ($budgets as $budget) {
            $transactions = Transaction::whereIn('category_id', $budget->categories->pluck('id'))
                ->whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year)
                ->get()
                ->map(function ($transaction) {
                    $transaction->amount = abs($transaction->amount);
                    return $transaction;
                });

            $budget->balance = $transactions->sum('amount');
        }

        return view('budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new budget.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::visibleToUser()->get();
        $bankingRecords = BankingRecord::where('user_id', Auth::id())->get();

        return view('budgets.form', compact('categories', 'bankingRecords'));
    }

    /**
     * Store a newly created budget in storage.
     *
     * @param \App\Http\Requests\BudgetRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BudgetRequest $request)
    {
        Budget::validateAndCreate($request);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget created successfully');
    }

    /**
     * Display the specified budget.
     *
     * @param int $budgetId
     * @return \Illuminate\View\View
     */
    public function show($budgetId)
    {
        $budget = Budget::with('categories')->findOrFail($budgetId);
        $categoryIds = $budget->categories->pluck('categories.id')->toArray();

        $transactions = Transaction::where('type', 'expense')
            ->whereIn('category_id', $categoryIds)
            ->get()
            ->map(function ($transaction) {
                $transaction->amount = abs($transaction->amount);
                return $transaction;
            });

        $bankingRecords = BankingRecord::all();

        return view('budgets.show', compact('budget', 'transactions', 'bankingRecords'));
    }

    /**
     * Show the form for editing the specified budget.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        $categories = Category::visibleToUser()->get();
        $bankingRecords = BankingRecord::where('user_id', Auth::id())->get();

        return view('budgets.form', compact('budget', 'categories', 'bankingRecords'));
    }

    /**
     * Update the specified budget in storage.
     *
     * @param \App\Http\Requests\BudgetRequest $request
     * @param \App\Models\Budget $budget
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BudgetRequest $request, Budget $budget)
    {
        $budget->updateAndSyncCategories($request);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget updated successfully');
    }

    /**
     * Remove the specified budget from storage.
     *
     * @param \App\Models\Budget $budget
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Budget $budget)
    {
        $budget->categories()->detach();
        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully');
    }

    /**
     * Display the transaction history for the specified budget.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $budgetId
     * @return \Illuminate\View\View
     */
    public function history(Request $request, $budgetId)
    {
        $budget = Budget::findOrFail($budgetId);
        $categoryIds = $budget->categories()->pluck('categories.id')->toArray();

        $query = Transaction::selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(ABS(amount)) as total_amount')
            ->whereIn('category_id', $categoryIds)
            ->groupByRaw('YEAR(date), MONTH(date)');

        if ($year = $request->input('year')) {
            $query->whereYear('date', $year);
        }

        if ($monthName = $request->input('month')) {
            $monthNumber = Carbon::parse($monthName)->month;
            $query->whereMonth('date', $monthNumber);
        }

        $transactions = $query->get()->map(function ($transaction) use ($budget) {
            $transaction->remaining_amount = $budget->amount - $transaction->total_amount;
            $transaction->month_name = Carbon::create()->month($transaction->month)->format('F');
            return $transaction;
        });

        if ($sortSpent = $request->input('sort_spent')) {
            $transactions = $sortSpent === 'highest' ? $transactions->sortByDesc('total_amount') : $transactions->sortBy('total_amount');
        }

        if ($sortRemaining = $request->input('sort_remaining')) {
            $transactions = $sortRemaining === 'highest' ? $transactions->sortByDesc('remaining_amount') : $transactions->sortBy('remaining_amount');
        }

        \Log::info('Transactions retrieved for history:', $transactions->toArray());

        return view('budgets.history', compact('budget', 'transactions', 'year', 'monthName', 'sortSpent', 'sortRemaining'));
    }
}