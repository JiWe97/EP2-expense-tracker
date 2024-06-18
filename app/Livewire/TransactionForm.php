<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\BankingRecord;
use App\Models\Attachment;
use App\Models\Payoff;
use Illuminate\Support\Facades\Auth;

class TransactionForm extends Component
{
    use WithFileUploads;

    public $is_income = false;
    public $date;
    public $amount;
    public $category_id;
    public $description;
    public $banking_record_id;
    public $attachments = [];
    public $transaction;
    public $payoff_id;
    public $type;

    public function mount($transaction = null)
    {
        if ($transaction) {
            $this->transaction = $transaction;
            $this->is_income = $transaction->type === 'income';
            $this->date = $transaction->date;
            $this->amount = abs($transaction->amount);
            $this->category_id = $transaction->category_id;
            $this->description = $transaction->description;
            $this->banking_record_id = $transaction->banking_record_id;
            $this->payoff_id = $transaction->payoff_id;
            $this->type = $transaction->type;
        }
    }

    public function updatedIsIncome()
    {
        $this->category_id = null; // Reset category when type changes
    }

    public function saveOrUpdate()
    {
        $this->validate([
            'is_income' => 'required|boolean',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'banking_record_id' => 'required|exists:banking_records,id',
            'payoff_id' => 'nullable|exists:payoffs,id',
            'attachments.*' => 'file|max:1024',
        ]);

        $amount = $this->is_income ? $this->amount : -abs($this->amount);
        $type = $this->is_income ? 'income' : 'expense';

        $data = [
            'type' => $type,
            'date' => $this->date,
            'amount' => $amount,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'banking_record_id' => $this->banking_record_id,
            'user_id' => Auth::id(),
            'payoff_id' => $this->payoff_id,
        ];

        if ($this->transaction) {
            $this->updateTransaction($data, $amount);
        } else {
            $this->createTransaction($data, $amount);
        }

        $this->saveAttachments();

        return redirect()->route('transactions.index')->with('success', 'Transaction saved successfully.');
    }

    private function createTransaction($data, $amount)
    {
        $transaction = Transaction::create($data);
        $this->updateBankingRecordBalance($data['banking_record_id'], $amount);
        $this->updatePayoffBalance($data['payoff_id'], $amount, $data['type']);
    }

    private function updateTransaction($data, $newAmount)
    {
        $transaction = Transaction::find($this->transaction->id);
        $oldAmount = $transaction->amount;

        // Reverse the effect of the old amount
        $this->updateBankingRecordBalance($transaction->banking_record_id, -$oldAmount);
        $this->updatePayoffBalance($transaction->payoff_id, -$oldAmount, $transaction->type);

        // Update the transaction
        $transaction->update($data);

        // Apply the new amount
        $this->updateBankingRecordBalance($data['banking_record_id'], $newAmount);
        $this->updatePayoffBalance($data['payoff_id'], $newAmount, $data['type']);
    }

    private function updateBankingRecordBalance($bankingRecordId, $amount)
    {
        $bankingRecord = BankingRecord::find($bankingRecordId);
        if ($bankingRecord) {
            $bankingRecord->balance += $amount;
            $bankingRecord->save();
        }
    }

    private function updatePayoffBalance($payoffId, $amount, $type)
    {
        if ($payoffId) {
            $payoff = Payoff::find($payoffId);
            if ($payoff) {
                // Switch positive and negative amounts for payoff balance
                if ($type === 'income') {
                    $payoff->balance -= abs($amount);
                } else {
                    $payoff->balance += abs($amount);
                }
                $payoff->save();
            }
        }
    }

    private function saveAttachments()
    {
        foreach ($this->attachments as $file) {
            $path = $file->store('attachments', 'public');
            Attachment::create([
                'picture' => $path,
                'transaction_id' => $this->transaction->id
            ]);
        }
    }

    public function render()
    {
        $categories = Category::where('user_id', Auth::id())
            ->where('is_income', $this->is_income)
            ->get();
        $bankingRecords = BankingRecord::where('user_id', Auth::id())->get();
        $payoffs = Payoff::all(); // Fetch all payoffs

        return view('livewire.transaction-form', compact('categories', 'bankingRecords', 'payoffs'));
    }
}
