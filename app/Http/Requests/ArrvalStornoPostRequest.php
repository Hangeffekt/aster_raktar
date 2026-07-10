<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ArrvalStornoPostRequest extends FormRequest
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
        $rules = [];
        $rules['closeNote'] = ['required'];

        foreach ($this->all() as $key => $value) {

            if (str_starts_with($key, 'net_price_')) {
                $rules[$key] = ['required', 'numeric', 'min:0'];
            }

            if (str_starts_with($key, 'sale_price_')) {
                $rules[$key] = ['required', 'numeric', 'min:0'];
            }
            
            if (str_starts_with($key, 'qty_')) {
                $rules[$key] = ['required', 'integer', 'min:1'];
            }
        }

        return $rules;
    }

    protected function passedValidation()
    {
        $items = [];

        foreach ($this->all() as $key => $value) {
            if (str_starts_with($key, 'net_price_')) {
                $uuid = str_replace('net_price_', '', $key);

                $items[$uuid] = [
                    'net_price' => $this->input("net_price_{$uuid}"),
                    'sale_price' => $this->input("sale_price_{$uuid}"),
                    'qty' => $this->input("qty_{$uuid}"),
                ];
            }
        }
        
        $this->merge([
            'storno_items' => $items
        ]);
    }
}
