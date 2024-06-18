<?php

namespace App\Http\Controllers;

use App\Models\BankingRecord;
use App\Models\Transaction;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // Assuming authentication middleware is applied
        $bankingRecords = BankingRecord::where('user_id', $userId)->get();
        $transactions = Transaction::with(['bankingRecord', 'category'])
            ->where('user_id', $userId)
            ->get();
        $totalBalance = $bankingRecords->sum('balance'); // Calculate the total balance

        return view('dashboard', ['bankingRecords' => $bankingRecords, 'totalBalance' => $totalBalance, 'transactions' => $transactions]);
    }
}
