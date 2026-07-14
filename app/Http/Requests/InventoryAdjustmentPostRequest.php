<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

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
        return [
            'adjustment_uuid' => 'required|uuid|exists:adjustment_types,uuid'
        ];
    }

    protected function passedValidation(): void
    {
        $adjustmentId = DB::table('adjustment_types')->where('uuid', $this->adjustment_uuid)->first();
        $this->merge(['adjustmentId' => $adjustmentId->id]);
        $this->request->remove('suplier_uuid');
    }
}
