<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BankingRecord;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Attachment;
use App\Models\Goal;
use App\Models\GoalTransaction;
use App\Models\Payoff;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TransactionRequest;
use App\Imports\TransactionsImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BankStatementsImport;
use Exception;

class TransactionController extends Controller
{
    public function create()
    {
        $categories = Category::where('show', true)
            ->where('user_id', Auth::id())
            ->get();
        $bankingRecords = BankingRecord::where('user_id', Auth::id())->get();

        return view('transactions.create', compact('categories', 'bankingRecords'));
    }

    public function show()
    {
        $userId = Auth::id();
        $transactions = Transaction::where('user_id', $userId)->paginate(10); // Add pagination and filter by user_id
        return view('dashboard', compact('transactions'));
    }

    public function edit(Transaction $transaction)
    {
        $categories = Category::where('show', true)
            ->where('user_id', Auth::id())
            ->whereNull('deleted_at') // Exclude soft-deleted categories
            ->get();
        $bankingRecords = BankingRecord::where('user_id', Auth::id())->get();

        return view('transactions.edit', compact('transaction', 'categories', 'bankingRecords'));
    }

    public function destroy(Transaction $transaction)
    {
        $bankingRecord = BankingRecord::find($transaction->banking_record_id);
        if ($bankingRecord) {
            $bankingRecord->balance -= $transaction->amount;
            $bankingRecord->save();

            Log::info('Transaction amount reverted:', [
                'id' => $bankingRecord->id,
                'new_balance' => $bankingRecord->balance,
            ]);
        }

        if ($transaction->payoff_id) {
            $this->updatePayoffBalanceOnDelete($transaction);
        }

        $transaction->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Transaction deleted successfully.');
    }

    private function updatePayoffBalanceOnDelete(Transaction $transaction)
    {
        $payoff = Payoff::find($transaction->payoff_id);
        if ($payoff) {
            // Switch the logic for removing the amount from the payoff balance
            if ($transaction->type === 'income') {
                $payoff->balance += abs($transaction->amount);
            } else {
                $payoff->balance -= abs($transaction->amount);
            }
            $payoff->save();

            Log::info('Payoff balance updated on transaction delete:', [
                'id' => $payoff->id,
                'new_balance' => $payoff->balance,
            ]);
        }
    }

    public function search(Request $request)
    {
        $userId = Auth::id();
        $query = Transaction::with(['user', 'bankingRecord', 'category' => function($query) {
            $query->withTrashed(); // Include soft-deleted categories
        }])
        ->where('user_id', $userId); // Filter transactions by the authenticated user's ID

        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        if ($request->filled('amount')) {
            $query->where('amount', $request->amount);
        }

        if ($request->filled('banking_record')) {
            $query->whereHas('bankingRecord', function($q) use ($request) {
                $q->where('bank_name', 'like', '%' . $request->banking_record . '%');
            });
        }

        if ($request->filled('payoff')) {
            $query->whereHas('payoff', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->payoff . '%');
            });
        }

        return $query->paginate(10);
    }

    public function showImportForm()
    {
        return view('transactions.import');
    }

    // Method to handle the file preview
    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads');

            // Read the file content
            $fileContent = array_map('str_getcsv', file(Storage::path($path)));

            return back()->with([
                'fileContent' => $fileContent,
                'filePath' => $path,
            ]);
        } else {
            return back()->withErrors(['file' => 'No file uploaded.']);
        }
    }

    // Method to handle the file import
    public function import(Request $request)
    {
        $filePath = $request->input('file_path');

        if ($filePath) {
            try {
                // Log file upload start
                Log::info('File import started');

                $userId = Auth::id(); // Get the current user's ID
                Excel::import(new BankStatementsImport($userId), Storage::path($filePath));

                // Log file upload success
                Log::info('File import completed successfully');

                // Delete the temporary file
                Storage::delete($filePath);

                return redirect()->route('dashboard')->with('success', 'Transactions imported successfully.');
            } catch (Exception $ex) {
                // Log exception
                Log::error('File import error: ' . $ex->getMessage());
                Log::error($ex->getTraceAsString());

                return redirect()->route('transactions.import')->withErrors(['file' => 'Some error has occurred. Please try again.']);
            }
        } else {
            // Log no file error
            Log::error('No file path provided');

            return redirect()->route('transactions.import')->withErrors(['file' => 'No file uploaded.']);
        }
    }
}
