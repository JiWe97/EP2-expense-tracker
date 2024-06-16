<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->hasFile('file')) {
            return [
                'file' => 'required|file|mimes:csv,txt|max:2048',
            ];
        } else {
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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
