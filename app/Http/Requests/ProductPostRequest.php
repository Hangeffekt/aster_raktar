<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Brand;
use App\Models\Tax;
use App\Models\Catalog;
use Illuminate\Validation\Rule;

class ProductPostRequest extends FormRequest
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
        $productId = $this->route('product')?->id ?? $this->route('product');

        return [
            'brand_uuid' => 'required|uuid|exists:brands,uuid',
            'product_name' => ['required','string','max:255',Rule::unique('products', 'product_name')->ignore($productId)],
            'ean' => ['required','numeric',Rule::unique('products', 'ean')->ignore($productId)],
            'sale_price' => 'numeric',
            'tax_uuid' => 'required|uuid|exists:taxes,uuid',
            'catalog_uuid' => 'required|uuid|exists:catalogs,uuid',
        ];
    }

    protected function passedValidation(): void
    {
        $brandId = Brand::where('uuid', $this->brand_uuid)->first();
        $taxId = Tax::where('uuid', $this->tax_uuid)->first();
        $catalogId = Catalog::where('uuid', $this->catalog_uuid)->first();
        $this->merge(['brand_id' => $brandId->brand_id]);
        $this->merge(['tax_id' => $taxId->tax_id]);
        $this->merge(['catalog_id' => $catalogId->catalog_id]);
        $this->request->remove('brand_uuid');
        $this->request->remove('tax_uuid');
        $this->request->remove('catalog_uuid');
    }
}
