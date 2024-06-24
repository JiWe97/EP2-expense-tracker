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

    /**
     * Initialize the component with the given transaction data.
     *
     * @param \App\Models\Transaction|null $transaction
     * @return void
     */
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

    /**
     * Update the category_id when the income status changes.
     *
     * @return void
     */
    public function updatedIsIncome()
    {
        $this->category_id = null;
    }

    /**
     * Validate and save or update the transaction.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

        return redirect()->route('dashboard')->with('success', 'Transaction saved successfully.');
    }

    /**
     * Create a new transaction and update related balances.
     *
     * @param array $data
     * @param float $amount
     * @return void
     */
    private function createTransaction($data, $amount)
    {
        $transaction = Transaction::create($data);
        $this->transaction = $transaction;
        $this->updateBankingRecordBalance($data['banking_record_id'], $amount);
        $this->updatePayoffBalance($data['payoff_id'], $amount, $data['type']);
    }

    /**
     * Update an existing transaction and related balances.
     *
     * @param array $data
     * @param float $newAmount
     * @return void
     */
    private function updateTransaction($data, $newAmount)
    {
        $transaction = Transaction::find($this->transaction->id);
        $oldAmount = $transaction->amount;

        $this->updateBankingRecordBalance($transaction->banking_record_id, -$oldAmount);
        $this->updatePayoffBalance($transaction->payoff_id, -$oldAmount, $transaction->type);

        $transaction->update($data);

        $this->updateBankingRecordBalance($data['banking_record_id'], $newAmount);
        $this->updatePayoffBalance($data['payoff_id'], $newAmount, $data['type']);
    }

    /**
     * Update the balance of the specified banking record.
     *
     * @param int $bankingRecordId
     * @param float $amount
     * @return void
     */
    private function updateBankingRecordBalance($bankingRecordId, $amount)
    {
        $bankingRecord = BankingRecord::find($bankingRecordId);
        if ($bankingRecord) {
            $bankingRecord->balance += $amount;
            $bankingRecord->save();
        }
    }

    /**
     * Update the balance of the specified payoff.
     *
     * @param int|null $payoffId
     * @param float $amount
     * @param string $type
     * @return void
     */
    private function updatePayoffBalance($payoffId, $amount, $type)
    {
        if ($payoffId) {
            $payoff = Payoff::find($payoffId);
            if ($payoff) {
                if ($type === 'income') {
                    $payoff->balance -= abs($amount);
                } else {
                    $payoff->balance += abs($amount);
                }
                $payoff->save();
            }
        }
    }

    /**
     * Save the uploaded attachments for the transaction.
     *
     * @return void
     */
    private function saveAttachments()
    {
        if ($this->transaction) {
            foreach ($this->attachments as $file) {
                $path = $file->store('attachments', 'public');
                Attachment::create([
                    'picture' => $path,
                    'transaction_id' => $this->transaction->id,
                ]);
            }
        }
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $categories = Category::where('user_id', Auth::id())
            ->where('is_income', $this->is_income)
            ->where('show', true)
            ->get();
        $bankingRecords = BankingRecord::where('user_id', Auth::id())->get();
        $payoffs = Payoff::all();

        return view('livewire.transaction-form', compact('categories', 'bankingRecords', 'payoffs'));
    }
}
