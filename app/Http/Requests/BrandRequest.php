<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $brandId = $this->route('brand')?->id;

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands', 'title')->ignore($brandId),
            ],
            'content'        => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_image'   => 'sometimes|boolean',
            'invited_emails' => 'nullable|string',
            'user_ids'       => 'nullable|array',
            'user_ids.*'     => 'integer|exists:users,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->boolean('remove_image')) {
            $this->merge(['image_path' => null]);
        }
    }
}
