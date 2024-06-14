<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;
use App\Models\GoalTransaction;

class GoalTransactionController extends Controller
{
    public function index()
    {
        // dont need
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($goalId)
    {
        $goal = Goal::findOrFail($goalId);
        return view('goals.transactions.form', compact('goal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'goal_id' => 'required|exists:goals,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:Add,Remove',
        ]);

        GoalTransaction::create($request->all());

        return redirect()->route('goals.show', $request->goal_id)->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // dont need
    }

    /**
     * Show the form for editing the specified resource.
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
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'goal_id' => 'required|exists:goals,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:Add,Remove',
        ]);

        $goal_transaction = GoalTransaction::findOrFail($id);
        
        // Debugging statements
        \Log::info('Updating transaction:', $validated);
        \Log::info('Goal Transaction before update:', $goal_transaction->toArray());

        $goal_transaction->update($validated);

        \Log::info('Goal Transaction after update:', $goal_transaction->toArray());

        return redirect()->route('goals.show', $request->goal_id)->with('success', 'Transaction updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $goal_transaction = GoalTransaction::findOrFail($id);
        $goalId = $goal_transaction->goal_id;
        $goal_transaction->delete();

        return redirect()->route('goals.show', $goalId)->with('success', 'Transaction deleted successfully.');
    }
}
