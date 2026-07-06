<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Suplier;

class ArrivalPostRequest extends FormRequest
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
            'suplier_uuid' => 'required|uuid|exists:supliers,uuid',
            'arrival_date' => 'required|date',
            'payment_date' => 'required|date',
            'suplier_note_number' => 'string|max:255',
            'invoice_number' => 'string|max:255'
        ];
    }

    protected function passedValidation(): void
    {
        $suplierId = Suplier::where('uuid', $this->suplier_uuid)->first();
        $this->merge(['suplier_id' => $suplierId->suplier_id]);
        $this->request->remove('suplier_uuid');
    }
}
