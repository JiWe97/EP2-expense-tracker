<?php

namespace App\Imports;

use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BankStatementsImport implements ToModel, WithHeadingRow
{
    /**
     * Define the model for each row in the import file.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $rules = [
            'id' => 'required|integer',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'category_id' => 'required|integer',
            'user_id' => 'required|integer',
            'description' => 'nullable|string',
            'banking_record_id' => 'required|integer',
            'type' => 'required|string',
            'valuta' => 'required|in:EUR,USD',
            'payoff_id' => 'nullable|integer',
            'created_at' => 'required|date',
            'updated_at' => 'required|date',
        ];

        $validator = Validator::make($row, $rules);

        // If validation fails, log the errors and return null to skip the row
        if ($validator->fails()) {
            Log::error('Validation failed: ', $validator->errors()->toArray());
            return null;
        }

        // Create the new Transaction model
        $transaction = new Transaction([
            'id' => (int) $row['id'],
            'date' => $row['date'],
            'amount' => (float) $row['amount'],
            'category_id' => (int) $row['category_id'],
            'user_id' => (int) $row['user_id'],
            'description' => $row['description'],
            'banking_record_id' => (int) $row['banking_record_id'],
            'type' => $row['type'],
            'valuta' => $row['valuta'],
            'payoff_id' => $row['payoff_id'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);

        // Save the transaction and log the result
        if ($transaction->save()) {
            Log::info('Transaction saved: ', $transaction->toArray());
        } else {
            Log::error('Failed to save transaction: ', $transaction->toArray());
        }

        return $transaction;
    }
}
