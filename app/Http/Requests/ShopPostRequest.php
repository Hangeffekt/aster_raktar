<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopPostRequest extends FormRequest
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
        $shopId = $this->route('shop')?->id ?? $this->route('shop');
        
        return [
            'shop_name' => ['required','string','max:255',Rule::unique('shops', 'shop_name')->ignore($shopId)],
            'shop_zip_code' => 'numeric|min_digits:4|max_digits:4',
            'shop_address' => 'required|string|min:4|max:255',
            'shop_settlement' => 'required|string|min:2|max:255',
            'shop_tax_number' => ['required','numeric',Rule::unique('shops', 'shop_tax_number')->ignore($shopId)],
            'shop_phone' => 'numeric|min_digits:8|max_digits:11',
            'shop_email' => 'required|string|max:255|email'
        ];
    }
}
