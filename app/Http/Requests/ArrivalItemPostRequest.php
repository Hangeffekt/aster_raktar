<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\ArrivalItem;
use App\Models\Product;

class ArrivalItemPostRequest extends FormRequest
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
        $arrivalItemId = $this->route('arrivalitem')?->id ?? $this->route('arrivalitem');
        
        return [
            'arrival_table_id' => ['nullable',
                Rule::requiredIf(function () use ($arrivalItemId) {
                    return ($arrivalItemId != null) ? !ArrivalItem::where('uuid', $arrivalItemId->uuid)->exists() : true;
                }),'uuid',
                'exists:arrivals,uuid'],
            'item_id' => ['nullable',
                Rule::requiredIf(function () use ($arrivalItemId) {
                    return ($arrivalItemId != null) ? !ArrivalItem::where('uuid', $arrivalItemId->uuid)->exists() : true;
                }),
                'uuid',
                'exists:products,uuid'],
            'net_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'qty' => 'required|numeric'
        ];
    }

    protected function passedValidation(): void
    {
        $productId = Product::where('uuid', $this->item_id)->first();
        $this->merge(['item_id' => $productId->product_id]);
    }
}
