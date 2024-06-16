<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'displayname' => 'required|max:255',
            'color' => 'required',
            'icon' => 'required',
        ];
    }
}
