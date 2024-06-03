<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; // For user-specific transactions
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = (new Transaction)->newQuery();

        // Apply filtering based on request parameters or other logic (optional)
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($startDate && $endDate) {
            $transactions->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Filter by user (assuming user association)
        $transactions->where('user_id', Auth::id());

        // Order, limit, and retrieve transactions
        $transactions = $transactions->latest()->limit(10)->get();

        return view('dashboard.index', compact('transactions'));
    }
}
