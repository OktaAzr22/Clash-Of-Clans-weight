<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchClanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $tag = trim($this->tag);
        // Pastikan tag diawali tanda '#' jika pengguna lupa memasukkannya
        if ($tag && !str_starts_with($tag, '#')) {
            $tag = '#' . $tag;
        }

        $this->merge([
            'tag' => strtoupper($tag),
        ]);
    }

    public function rules(): array
    {
        return [
            'tag' => [
                'required',
                'string',
                'min:3',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tag.required' => 'Tag clan wajib diisi.',
            'tag.min' => 'Tag clan tidak valid.',
        ];
    }
}