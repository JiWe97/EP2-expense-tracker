<?php

namespace App\Imports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BankStatementsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Log the row data
        Log::info('Importing row: ', $row);

        // Define the validation rules
        $rules = [
            'id' => 'required|integer',
            'amount' => 'required|numeric',
            'category_id' => 'required|integer',
            'user_id' => 'required|integer',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'valuta' => 'required|in:EUR,USD',
            'recipient_id' => 'required|integer',
            'exchange_rate' => 'nullable|numeric',
            'warranty' => 'nullable|boolean',
            'warranty_date' => 'nullable|date',
            'banking_record_id' => 'required|integer',
            'created_at' => 'required|date',
            'updated_at' => 'required|date',
        ];

        // Validate the row before processing
        $validator = Validator::make($row, $rules);

        // If validation fails, log the errors and return null to skip the row
        if ($validator->fails()) {
            Log::error('Validation failed: ', $validator->errors()->toArray());
            return null;
        }

        // Log successful validation
        Log::info('Validation passed: ', $row);

        // Create the new Transaction model
        $transaction = new Transaction([
            'id' => (int) $row['id'],
            'amount' => (float) $row['amount'], // Ensure amount is a float
            'category_id' => (int) $row['category_id'],
            'user_id' => (int) $row['user_id'],
            'description' => $row['description'],
            'type' => $row['type'],
            'valuta' => $row['valuta'],
            'recipient_id' => (int) $row['recipient_id'],
            'exchange_rate' => isset($row['exchange_rate']) ? (float) $row['exchange_rate'] : null, // Nullable field
            'warranty' => isset($row['warranty']) ? (bool) $row['warranty'] : null, // Nullable field
            'warranty_date' => isset($row['warranty_date']) ? $row['warranty_date'] : null, // Nullable field
            'banking_record_id' => (int) $row['banking_record_id'],
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
