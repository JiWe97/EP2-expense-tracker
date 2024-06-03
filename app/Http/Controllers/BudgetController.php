<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Http\Requests\BudgetRequest;


class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.budgets.index', ['budgets' => Budget::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.budgets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BudgetRequest $request)
    {
        $budget = Budget::create($request->validated());
        return redirect()->route('budgets.index', ['budget' => $budget->id])
            ->with('success', 'Budget created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        return view('settings.budgets.edit', ['budget' => $budget]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BudgetRequest $request, Budget $budget)
    {
        $budget->update($request->validated());
        return redirect()->route('budgets.index', ['budget' => $budget->name])
            ->with('success', 'budget updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        $category->delete();
        return redirect()->route('budgets.index')
            ->with('success', 'budget deleted successfully');
    }
}
