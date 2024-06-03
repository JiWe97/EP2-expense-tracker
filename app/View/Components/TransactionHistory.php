<?php

namespace App\View\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $bankRecords = Transaction::latest()->limit(10)->get(); // Latest 10 records (modify as needed)

        return view('dashboard.index', compact('transaction'));
    }
}