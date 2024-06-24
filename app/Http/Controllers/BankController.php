<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankingRecord;

class BankController extends Controller
{
    //Store a new banking record
    public function store(Request $request)
    {
        // Validate incoming request data to ensure required fields are present and balance is numeric
        $validated = $request->validate([
            'name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'balance' => 'required|numeric',
        ]);

        // Create a new instance of the BankingRecord model with validated data and save it to the database.
        $bankingRecord = new BankingRecord([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'balance' => $validated['balance'],
        ]);

        // Save the new banking record to the database.
        $bankingRecord->save();

        // Redirect the user to profile page with a success message
        return redirect('/profile')->with('success', 'Banking information created successfully');
    }

    // Form for editing existing banking records.
    public function edit(BankingRecord $bankingRecord)
    {
        // Pass the selected banking record to the view for editing.
        return view('profile.partials.edit-bank-record', compact('bankingRecord'));
    }

    //Updates an existing banking record with new data.
    public function update(Request $request, BankingRecord $bankingRecord)
    {
        // Validate the incoming request data to ensure required fields are present and balance is numeric.
        $validated = $request->validate([
            'name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'balance' => 'required|numeric',
        ]);

        // Update the selected banking record with the validated data.
        $bankingRecord->update($validated);

        // Redirect back to profile page with a success message
        return redirect('/profile')->with('success', 'Banking information updated successfully');
    }

    // Deletes a banking record.
    public function destroy(BankingRecord $bankingRecord)
    {
        // Delete the selected banking record from the database.
        $bankingRecord->delete();

        // Redirectback to profile page with a success message
        return redirect('/profile')->with('success', 'Banking information deleted successfully');
    }

    // Adds a specified amount to the balance of a banking record.
    public function addBalance(Request $request, BankingRecord $bankingRecord)
    {
        // Validate the incoming request data to ensure the amount is present, numeric, and not negative.
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        // Add the validated amount to the current balance of the banking record and update it.
        $bankingRecord->update(['balance' => $bankingRecord->balance + $validated['amount']]);

        // Redirect back to profile page with a success message.
        return redirect('/profile')->with('success', 'Balance added successfully');
    }
}
