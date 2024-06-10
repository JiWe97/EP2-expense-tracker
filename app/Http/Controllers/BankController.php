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
        ]);

        //Store the banking record
        $bankingRecord = new BankingRecord([
            'user_id' => auth()->id(),
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
        ]);

        $bankingRecord->save();

        //Redirect or return a response
        return redirect('/profile')->with('success', 'Banking information created successfully');
    }
}
