<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankingRecord;

class BankController extends Controller
{
    /**
     * Store a new banking record.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'balance' => 'required|numeric',
        ]);

        $bankingRecord = new BankingRecord([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'balance' => $validated['balance'],
        ]);

        $bankingRecord->save();

        return redirect('/profile')->with('success', 'Banking information created successfully');
    }

    /**
     * Form for editing existing banking records.
     *
     * @param \App\Models\BankingRecord $bankingRecord
     * @return \Illuminate\View\View
     */
    public function edit(BankingRecord $bankingRecord)
    {
        return view('profile.partials.edit-bank-record', compact('bankingRecord'));
    }

    /**
     * Updates an existing banking record with new data.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BankingRecord $bankingRecord
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, BankingRecord $bankingRecord)
    {
        $validated = $request->validate([
            'name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'balance' => 'required|numeric',
        ]);

        $bankingRecord->update($validated);

        return redirect('/profile')->with('success', 'Banking information updated successfully');
    }

    /**
     * Deletes a banking record.
     *
     * @param \App\Models\BankingRecord $bankingRecord
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BankingRecord $bankingRecord)
    {
        $bankingRecord->delete();

        return redirect('/profile')->with('success', 'Banking information deleted successfully');
    }

    /**
     * Adds balance to an existing banking record.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BankingRecord $bankingRecord
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addBalance(Request $request, BankingRecord $bankingRecord)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $bankingRecord->update(['balance' => $bankingRecord->balance + $validated['amount']]);

        return redirect('/profile')->with('success', 'Balance added successfully');
    }
}
