<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payoff;
use App\Models\Transaction;

class PayoffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payoffs = Payoff::where('user_id', auth()->user()->id)->get();
        
        return view('payoffs.index', compact('payoffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payoffs.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'total' => 'required|numeric',
            'balance' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        Payoff::create($validatedData);

        return redirect()->route('payoffs.index')->with('success', 'Payoff created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payoff = Payoff::with('transaction')->findOrFail($id);
        
        return view('payoffs.show', compact('payoff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payoff $payoff)
    {
        return view('payoffs.form', compact('payoff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payoff $payoff)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'total' => 'required|numeric',
            'balance' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        $payoff->update($validatedData);

        return redirect()->route('payoffs.index')->with('success', 'Payoff updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payoff $payoff)
    {
        $payoff->delete();

        return redirect()->route('payoffs.index')->with('success', 'Payoff deleted successfully.');
    }

}
