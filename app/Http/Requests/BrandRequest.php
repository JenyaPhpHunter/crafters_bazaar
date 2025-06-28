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
                Rule::unique('brands', 'title')->ignore($brandId)
            ],
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'remove_image' => 'sometimes|boolean',
            'rating' => 'nullable|in:' . implode(',', array_keys(config('others.rating'))),
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'integer|exists:users,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->boolean('remove_image')) {
            $this->merge(['image_path' => null]);
        }
        // Тут тільки підготовка даних, без валідації
        // Наприклад:
        //Наприклад, перетворення рядка на число або видалення зайвих пробілів:
        //$this->merge([
        //    'user_id' => auth()->id(), // Додаємо ID поточного користувача
        //    'ip_address' => request()->ip(),
        //]);
        //$this->merge([
        //    'meta' => json_decode($this->meta_json, true),
        //]);
        //$this->merge([
        //    'phone' => preg_replace('/[^0-9]/', '', $this->phone),
        //]);
    }
}
