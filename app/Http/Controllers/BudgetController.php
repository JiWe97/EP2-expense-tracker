<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Http\Requests\BudgetRequest;
use App\Models\BankingRecord;
use App\Models\Category;
use App\Models\CustomCategory;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoricalBudget;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::all();
        return view('settings.budgets.index', compact('budgets'));
    }


    public function create()
    {
        $categories = Category::all();
        $banking_records = BankingRecord::all();
        $custom_categories = CustomCategory::where('user_id', Auth::id())->get();

        return view('settings.budgets.create', compact('categories', 'banking_records', 'custom_categories'));
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
        $categories = Category::all();
        $banking_records = BankingRecord::all();
        $custom_categories = CustomCategory::where('user_id', Auth::id())->get();

        return view('settings.budgets.edit', compact('budget', 'categories', 'banking_records', 'custom_categories'));
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

    public function history($budgetId)
    {
        $categoryIds = Budget::find($budgetId)->categories()->pluck('category_id')->toArray();
        $transactions = Transaction::selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(amount) as total_amount')
            ->whereIn('category_id', $categoryIds)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $budget = Budget::findOrFail($budgetId);

        return view('settings.budgets.history', [
            'budget' => $budget,
            'transactions' => $transactions,
        ]);
    }
    
}
