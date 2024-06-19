<?php

namespace App\Http\Controllers;

use App\Models\BankingRecord;
use App\Models\Transaction;
use App\Models\Goal;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $bankingRecords = BankingRecord::where('user_id', $userId)->get();
        $totalBalance = $bankingRecords->sum('balance');
        $goals = Goal::where('user_id', $userId)->get();
        $totalAmountSaved = GoalTransaction::whereIn('goal_id', $goals->pluck('id')->toArray())->sum('amount');
        $transactions = Transaction::with(['user', 'bankingRecord', 'category' => function($query) {
            $query->withTrashed(); // Include soft-deleted categories
        }])
        ->where('user_id', $userId) // Filter transactions by the authenticated user's ID
        ->paginate(10);

        $query = Transaction::with(['bankingRecord', 'category'])->where('user_id', $userId);

        if ($request->has('selectedBankNames')) {
            $selectedBankNames = explode(',', $request->selectedBankNames);
            $query->whereHas('bankingRecord', function ($query) use ($selectedBankNames) {
                $query->whereIn('bank_name', $selectedBankNames);
            });
        }

        $totalBalance = $bankingRecords->sum('balance');

        return view('dashboard', [
            'transactions' => $transactions,
            'categories' => Category::all(),
            'bankingRecords' => $bankingRecords,
            'totalAmountSaved' => $totalAmountSaved,
            'totalBalance' => $totalBalance
        ]);}
}
