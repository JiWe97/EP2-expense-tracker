<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'icon' => 'required|string|max:255',
            'show' => 'boolean',
            'is_income' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
