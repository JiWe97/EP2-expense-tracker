<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankingRecord;

class BankController extends Controller
{
    //Store new data in database
    public function store(Request $request)
    {
        //Validate the requested data
        $validated = $request->validate([
            'bank_name' => 'required',
            'account_number' => 'required',
            'balance' => 'required|numeric',
        ]);

        //Store the banking record
        $bankingRecord = new BankingRecord([
            'user_id' => auth()->id(),
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'balance' => $validated['balance'],
        ]);

        $bankingRecord->save();

        //Redirect or return a response
        return redirect('/profile')->with('success', 'Banking information created successfully');
    }

    public function edit(BankingRecord $bankingRecord)
    {
        return view('edit-bank-record', compact('bankingRecord'));
    }

    /*public function update(Request $request, BankingRecord $bankingRecord)
    {
        $validated = $request->validate([
            'bank_name' => 'required',
            'account_number' => 'required',
        ]);
        $bankingRecord->update([
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
        ]);

        return redirect('/profile')->with('success', 'Banking information updated successfully');
    } */

    public function destroy(BankingRecord $bankingRecord)
    {
        $bankingRecord->delete();
        return redirect('/profile')->with('success', 'Banking information deleted successfully');
    }

    public function addBalance(Request $request, BankingRecord $bankingRecord)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $bankingRecord->update(['balance' => $bankingRecord->balance + $validated['amount']]);

        return redirect('/profile')->with('success', 'Balance added successfully');
    }
}
