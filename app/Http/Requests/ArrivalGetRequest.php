<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Suplier;

class ArrivalGetRequest extends FormRequest
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
            'arrival_status' => 'nullable|string|max:255|in:PENDING,COMPLETED,STORNOED,STORNO',
            'suplier_uuid' => 'nullable|string|max:36',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'suplier_note_number' => 'nullable|string|max:255',
            'invoice_number' => 'nullable|string|max:255'
        ];
    }

    protected function passedValidation(): void
    {
        $suplier = Suplier::where('uuid', $this->suplier_uuid)->first();
        $this->merge(['suplier_id' => $suplier->suplier_id ?? null]);
        $this->request->remove('suplier_uuid');
    }
}
