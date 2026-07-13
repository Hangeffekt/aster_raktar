<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Product;

class InventoryAdjustmentPostRequest extends FormRequest
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
        $adjustmentItemId = $this->route('inventory_adjustment_item')?->id ?? $this->route('inventory_adjustment_item');

        return [
            'inner_table_id' => ['nullable',
                Rule::requiredIf(function () use ($adjustmentItemId) {
                    return ($adjustmentItemId == null) ?? true;
                }),'uuid',
                'exists:inventory_adjustments,uuid'],
            'product_id' => ['nullable',
                Rule::requiredIf(function () use ($adjustmentItemId) {
                    return ($adjustmentItemId == null) ?? true;
                }),
                'uuid',
                'exists:products,uuid'],
            'qty' => 'required|numeric'
        ];
    }

    protected function passedValidation(): void
    {
        if($this->product_id){
            $productId = Product::where('uuid', $this->product_id)->first();
            $this->merge(['product_id' => $productId->product_id]);
        }
        
    }
}
