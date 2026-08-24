<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClasherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'tag' => strtoupper(trim($this->tag)),
        ]);
    }

    public function rules(): array
    {
        return [
            'tag' => [
                'required',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tag.required' => 'Tag pemain wajib diisi.',
        ];
    }
}