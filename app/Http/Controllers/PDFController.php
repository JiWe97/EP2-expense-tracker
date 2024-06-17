<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use PDF;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDF()
    {
        // Fetch all transactions with their related category
        $transactions = Transaction::with('category')->get();

        // Filter expense transactions
        $expenseTransactions = $transactions->filter(function ($transaction) {
            return $transaction->type === 'expense';
        });

        // Group filtered transactions by category_id and sum the amount
        $categoryTotals = $expenseTransactions->groupBy('category_id')->map(function ($categoryTransactions) {
            return $categoryTransactions->sum('amount');
        });

        // Pre-fetch categories to avoid multiple queries
        $categories = Category::whereIn('id', $categoryTotals->keys())->pluck('name', 'id');

        // Map category IDs to category names and keep the totals
        $categoryTotalsWithName = $categoryTotals->mapWithKeys(function ($total, $categoryId) use ($categories) {
            $name = $categories->get($categoryId, 'Unknown Category');
            return [$name => $total];
        });

        // Format transaction data for the PDF view
        $transactionData = $transactions->map(function ($transaction) {
            return [
                'type' => $transaction->type,
                'amount' => $transaction->amount,
                'date' => $transaction->created_at ? $transaction->created_at->format('d-m-Y') : null,
            ];
        })->sortBy('date')->values()->toArray(); // Sort by date and reset keys

        // Data to pass to the PDF view
        $data = [
            'title' => 'Transaction Report',
            'transactions' => $transactionData,
            'categoryTotals' => $categoryTotalsWithName,
        ];

        // Generate PDF using the pdf.blade.php view and return as stream
        $pdf = PDF::loadView('pdf', $data);
        return $pdf->stream('transaction_report.pdf');
    }
}
