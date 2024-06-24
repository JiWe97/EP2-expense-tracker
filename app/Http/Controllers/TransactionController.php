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
    /**
     * Show the form for creating a new transaction.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::where('show', true)
            ->where('user_id', Auth::id())
            ->get();
        $bankingRecords = BankingRecord::where('user_id', Auth::id())->get();

        return view('transactions.create', compact('categories', 'bankingRecords'));
    }

    /**
     * Display the transactions of the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $userId = Auth::id();
        $transactions = Transaction::where('user_id', $userId)->paginate(10);

        return view('dashboard', compact('transactions'));
    }

    /**
     * Show the form for editing the specified transaction.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\View\View
     */
    public function edit(Transaction $transaction)
    {
        $categories = Category::where('show', true)
            ->where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->get();
        $bankingRecords = BankingRecord::where('user_id', Auth::id())->get();

        return view('transactions.edit', compact('transaction', 'categories', 'bankingRecords'));
    }

    /**
     * Remove the specified transaction from storage.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Update the payoff balance when a transaction is deleted.
     *
     * @param \App\Models\Transaction $transaction
     * @return void
     */
    private function updatePayoffBalanceOnDelete(Transaction $transaction)
    {
        $payoff = Payoff::find($transaction->payoff_id);
        if ($payoff) {
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

    /**
     * Search for transactions based on criteria.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(Request $request)
    {
        $userId = Auth::id();
        $query = Transaction::with(['user', 'bankingRecord', 'category' => function ($query) {
            $query->withTrashed();
        }])
        ->where('user_id', $userId);

        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
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
            $query->whereHas('bankingRecord', function ($q) use ($request) {
                $q->where('bank_name', 'like', '%' . $request->banking_record . '%');
            });
        }

        if ($request->filled('payoff')) {
            $query->whereHas('payoff', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->payoff . '%');
            });
        }

        return $query->paginate(10);
    }

    /**
     * Show the form for importing transactions.
     *
     * @return \Illuminate\View\View
     */
    public function showImportForm()
    {
        return view('transactions.import');
    }

    /**
     * Handle the file preview.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads');

            $fileContent = array_map('str_getcsv', file(Storage::path($path)));

            return back()->with([
                'fileContent' => $fileContent,
                'filePath' => $path,
            ]);
        }

        return back()->withErrors(['file' => 'No file uploaded.']);
    }

    /**
     * Handle the file import.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        $filePath = $request->input('file_path');

        if ($filePath) {
            try {
                Log::info('File import started');

                $userId = Auth::id();
                Excel::import(new BankStatementsImport($userId), Storage::path($filePath));

                Log::info('File import completed successfully');
                Storage::delete($filePath);

                return redirect()->route('dashboard')->with('success', 'Transactions imported successfully.');
            } catch (Exception $ex) {
                Log::error('File import error: ' . $ex->getMessage());
                Log::error($ex->getTraceAsString());

                return redirect()->route('transactions.import')->withErrors(['file' => 'Some error has occurred. Please try again.']);
            }
        }

        Log::error('No file path provided');

        return redirect()->route('transactions.import')->withErrors(['file' => 'No file uploaded.']);
    }
}
