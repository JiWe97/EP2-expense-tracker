<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required',
            'user_id' => 'required',
            'category_id' => 'required',
            'type' => 'required',
            'banking_record_id' => 'required',
            'valuta' => 'required',
        ];
    }
}