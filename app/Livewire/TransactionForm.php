<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\BankingRecord;
use Livewire\WithFileUploads;
use App\Models\Attachment;

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
    public $user_id;
    public $valuta = 'EUR';
    public $exchange_rate = 1.2;
    public $transaction;
    public $type;

    /**
     * Mount the component with an optional transaction.
     *
     * @param Transaction|null $transaction
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
            $this->type = $transaction->type;
        }
    }

    /**
     * Handle changes to the is_income property.
     *
     * @return void
     */
    public function updatedIsIncome()
    {
        $this->category_id = null; // Reset category when type changes
    }

    /**
     * Save or update the transaction.
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
            'user_id' => auth()->id(),
            'valuta' => $this->valuta,
            'exchange_rate' => $this->exchange_rate,
        ];

        if ($this->transaction) {
            $this->updateTransaction($data, $amount);
        } else {
            $this->createTransaction($data, $amount);
        }

        $this->saveAttachments();

        return redirect()->route('transactions.index')->with('success', 'Transaction saved successfully.');
    }

    /**
     * Create a new transaction.
     *
     * @param array $data
     * @param float $amount
     * @return void
     */
    private function createTransaction($data, $amount)
    {
        $this->transaction = Transaction::create($data);
        $this->updateBankingRecordBalance($this->banking_record_id, $amount);
    }

    /**
     * Update an existing transaction.
     *
     * @param array $data
     * @param float $amount
     * @return void
     */
    private function updateTransaction($data, $amount)
    {
        $transaction = Transaction::find($this->transaction->id);
        $this->updateBankingRecordBalance($transaction->banking_record_id, -$transaction->amount);
        $transaction->update($data);
        $this->updateBankingRecordBalance($this->banking_record_id, $amount);
    }

    /**
     * Update the balance of a banking record.
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
     * Save attachments for the transaction.
     *
     * @return void
     */
    private function saveAttachments()
    {
        foreach ($this->attachments as $file) {
            $path = $file->store('attachments', 'public');
            Attachment::create(['picture' => $path, 'transaction_id' => $this->transaction->id]);
        }
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $categories = Category::where('is_income', $this->is_income)->get();
        $bankingRecords = BankingRecord::where('user_id', auth()->id())->get();

        return view('livewire.transaction-form', compact('categories', 'bankingRecords'));
    }
}
