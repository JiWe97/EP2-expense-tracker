<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;
use App\Models\GoalTransaction;

class GoalTransactionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param int $goalId
     * @return \Illuminate\View\View
     */
    public function create($goalId)
    {
        $goal = Goal::findOrFail($goalId);
        return view('goals.transactions.form', compact('goal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'goal_id' => 'required|exists:goals,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:Add,Remove',
        ]);

        if ($validated['type'] === 'Remove') {
            $validated['amount'] = -abs($validated['amount']);
        }

        GoalTransaction::create($validated);

        return redirect()->route('goals.show', $validated['goal_id'])
            ->with('success', 'Transaction created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $goal_transaction = GoalTransaction::findOrFail($id);
        $goal = $goal_transaction->goal; // Ensure the relationship is defined in GoalTransaction model

        if (!$goal) {
            abort(404, 'Goal not found.');
        }

        return view('goals.transactions.form', compact('goal_transaction', 'goal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'goal_id' => 'required|exists:goals,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:Add,Remove',
        ]);

        if ($validated['type'] === 'Remove') {
            $validated['amount'] = -abs($validated['amount']);
        }

        $goal_transaction = GoalTransaction::findOrFail($id);

        $goal_transaction->update($validated);

        return redirect()->route('goals.show', $validated['goal_id'])
            ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $goal_transaction = GoalTransaction::findOrFail($id);
        $goalId = $goal_transaction->goal_id;
        $goal_transaction->delete();

        return redirect()->route('goals.show', $goalId)
            ->with('success', 'Transaction deleted successfully.');
    }
}
