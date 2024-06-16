<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Http\Requests\BudgetRequest;
use App\Models\BankingRecord;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::all();
        return view('settings.budgets.index', compact('budgets'));
    }


    public function create()
    {
        $categories = Category::where('show', true)->where('is_income', false)->where('user_id', Auth::id())->get();
        $banking_records = BankingRecord::all();

        return view('settings.budgets.create', compact('categories', 'banking_records'));
    }

    public function store(BudgetRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['banking_record_id'] = $request->input('banking_record_id');
        $validatedData['mail_when_completely_spent'] = $request->input('completely');
        $validatedData['mail_when_partially_spent'] = $request->input('partially');

        $budget = Budget::create($validatedData);

        // Attach category to the pivot table if 'category_id' is set
        if ($request->has('category_id')) {
            $budget->categories()->attach($request->input('category_id'));
        }

        return redirect()->route('budgets.index')
            ->with('success', 'Budget created successfully');
    }

    public function show(BankingRecord $banking_record, $budgetId)
    {
        $budget = Budget::findOrFail($budgetId);

        // Retrieve the category IDs associated with the budget
        $categoryIds = $budget->categories()->pluck('category_id')->toArray();

        // Retrieve the transactions that match the category IDs
        $transactions = Transaction::where('type', 'expense')
            ->whereIn('category_id', $categoryIds)
            ->get();

        // Convert transaction amounts to positive values
        $transactions->each(function ($transaction) {
            $transaction->amount = abs($transaction->amount);
        });

        $banking_records = BankingRecord::all(); // Fetch all banking records

        return view('settings.budgets.show', [
            'budget' => $budget,
            'transactions' => $transactions,
            'banking_records' => $banking_records,
        ]);
    }


    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        $categories = Category::where('show', true)->where('is_income', false)->where('user_id', Auth::id())->get();
        $banking_records = BankingRecord::all();

        return view('settings.budgets.edit', compact('budget', 'categories', 'banking_records'));
    }

    public function update(BudgetRequest $request, Budget $budget)
    {
        $validatedData = $request->validated();
        $validatedData['mail_when_completely_spent'] = $request->input('completely');
        $validatedData['mail_when_partially_spent'] = $request->input('partially');

        $budget->update($validatedData);

        // Sync category to the pivot table if 'category_id' is set
        if ($request->has('category_id')) {
            $budget->categories()->sync($request->input('category_id'));
        }

        return redirect()->route('budgets.index')
            ->with('success', 'Budget updated successfully');
    }

    public function destroy(Budget $budget)
    {
        // Delete the associated budget categories for this budget
        \DB::table('budget_category')
            ->where('budget_id', $budget->id)
            ->delete();

        // Now delete the budget
        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully');
    }

    public function history(Request $request, $budgetId)
    {
        $budget = Budget::findOrFail($budgetId);
        $totalBudget = $budget->amount;
        $categoryIds = $budget->categories()->pluck('category_id')->toArray();

    // Fetch query parameters
        $year = $request->input('year');
        $month = $request->input('month');
        $sortSpent = $request->input('sort_spent');
        $sortRemaining = $request->input('sort_remaining');

    // Build the base query
        $query = Transaction::selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(ABS(amount)) as total_amount')
        ->whereIn('category_id', $categoryIds)
        ->groupBy('year', 'month');

    // Apply year filter
        if ($year) {
            $query->whereRaw('YEAR(date) = ?', [$year]);
        }

    // Apply month filter
        if ($month) {
            $query->whereRaw('MONTH(date) = ?', [$month]);
        }

    // Fetch transactions
        $transactions = $query->get();

    // Calculate remaining budget and add month name
        $totalSpent = 0;
        $transactions->each(function ($transaction) use ($totalBudget, &$totalSpent) {
            $totalSpent += $transaction->total_amount;
            $transaction->remaining_amount = $totalBudget - $totalSpent;
            $transaction->month_name = \Carbon\Carbon::create()->month($transaction->month)->format('F');
        });

    // Sort by amount spent
        if ($sortSpent) {
            $transactions = $sortSpent == 'highest'
            ? $transactions->sortByDesc('total_amount')
            : $transactions->sortBy('total_amount');
        }

    // Sort by amount remaining
        if ($sortRemaining) {
            $transactions = $sortRemaining == 'highest'
            ? $transactions->sortByDesc('remaining_amount')
            : $transactions->sortBy('remaining_amount');
        }

        return view('settings.budgets.history', [
        'budget' => $budget,
        'transactions' => $transactions,
        'year' => $year,
        'month' => $month,
        'sortSpent' => $sortSpent,
        'sortRemaining' => $sortRemaining,
        ]);
    }
}
