<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Http\Requests\BudgetRequest;
use App\Models\BankingRecord;
use App\Models\Category;

class BudgetController extends Controller
{
    public function index()
    {
        return view('settings.budgets.index', ['budgets' => Budget::all()]);
    }

    public function create()
    {
        $banking_records = BankingRecord::all(); // Fetch all banking records
        $categories = Category::all();
        return view('settings.budgets.form', compact('banking_records', 'categories'));
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
        $budget = Budget::where('name', $budgetId)->first();
        $banking_records = BankingRecord::all(); // Fetch all banking records
        return view('settings.budgets.show', ['budget' => $budget]);
    }

    public function edit(Budget $budget)
    {
        $banking_records = BankingRecord::all();
        $categories = Category::all(); // Fetch all categories
        return view('settings.budgets.form', compact('budget', 'banking_records', 'categories'));
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
        $budget->delete();
        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully');
    }
}
