<?php

namespace App\Http\Controllers;

use App\Models\BankingRecord;
use App\Models\Transaction;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $bankingRecords = BankingRecord::where('user_id', $userId)->get();
        $perPage = 10;

        $query = Transaction::with(['bankingRecord', 'category'])->where('user_id', $userId);

        if ($request->has('selectedBankName')) {
            $query->whereHas('bankingRecord', function ($query) use ($request) {
                $query->where('bank_name', $request->selectedBankName);
            });
        }

        $transactions = $query->paginate($perPage);
        $totalBalance = $bankingRecords->sum('balance');

        return view('dashboard', ['bankingRecords' => $bankingRecords, 'totalBalance' => $totalBalance, 'transactions' => $transactions]);
    }
}
