<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Brand;
use App\Models\Tax;
use App\Models\Catalog;
use Illuminate\Validation\Rule;

class ProductFilterGetRequest extends FormRequest
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
            'brand_uuid' => 'nullable',
            'product_name' => 'nullable|string|max:255',
            'ean' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'tax_uuid' => 'nullable',
            'catalog_uuid' => 'nullable',
        ];
    }

    protected function passedValidation(): void
    {
        $brandId = Brand::where('uuid', $this->brand_uuid)->first();
        $taxId = Tax::where('uuid', $this->tax_uuid)->first();
        $catalogId = Catalog::where('uuid', $this->catalog_uuid)->first();
        $this->merge(['brand_id' => $brandId->brand_id ?? null]);
        $this->merge(['tax_id' => $taxId->tax_id ?? null]);
        $this->merge(['catalog_id' => $catalogId->catalog_id ?? null]);
        $this->request->remove('brand_uuid');
        $this->request->remove('tax_uuid');
        $this->request->remove('catalog_uuid');
    }
}
