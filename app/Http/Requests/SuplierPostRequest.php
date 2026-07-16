<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SuplierPostRequest extends FormRequest
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
        $suplierId = $this->route('suplier')?->id ?? $this->route('suplier');

        return [
            'suplier_name' => ['required','string','max:255',Rule::unique('supliers', 'suplier_name')->ignore($suplierId)],
            'suplier_zip_code' => 'numeric|min_digits:4|max_digits:4',
            'suplier_address' => 'required|string|min:4|max:255',
            'suplier_settlement' => 'required|string|min:2|max:255',
            'suplier_tax_number' => ['required','numeric',Rule::unique('supliers', 'suplier_tax_number')->ignore($suplierId)],
            'suplier_phone' => 'numeric|min_digits:8|max_digits:11',
            'suplier_email' => ['required','string','email','max:255',Rule::unique('supliers', 'suplier_email')->ignore($suplierId)],
        ];
    }
}
