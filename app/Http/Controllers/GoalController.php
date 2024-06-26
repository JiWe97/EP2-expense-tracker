<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use App\Models\GoalTransaction;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goals = Goal::where('user_id', auth()->user()->id)->get();
        
        return view('goals.index', compact('goals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('goals.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        Goal::create($request->all());

        return redirect()->route('goals.index')->with('success', 'Goal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($goalId)
    {
        $goal = Goal::findOrFail($goalId);
        $goalTransactions = GoalTransaction::where('goal_id', $goalId)->get();
        
        return view('goals.show', compact('goal', 'goalTransactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goal $goal)
    {
        return view('goals.form', ['goal' => $goal]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Goal $goal)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        $goal->update($validatedData);

        return redirect()->route('goals.index')->with('success', 'Goal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal)
    {
        $goal->delete();

        return redirect()->route('goals.index')->with('success', 'Goal deleted successfully.');
    }
}
