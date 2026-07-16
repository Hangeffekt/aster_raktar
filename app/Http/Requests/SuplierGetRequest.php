<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SuplierGetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'suplier_name' => 'nullable|string|max:255',
            'suplier_zip_code' => 'nullable|numeric|max_digits:4',
            'suplier_address' => 'nullable|string|max:255',
            'suplier_settlement' => 'nullable|string|max:255',
            'suplier_tax_number' => 'nullable|numeric',
            'suplier_phone' => 'nullable|numeric',
            'suplier_email' => 'nullable|string|max:255',
        ];
    }
}
