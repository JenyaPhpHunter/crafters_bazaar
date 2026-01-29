<?php

namespace App\Http\Requests;

use App\Constants\UserAndLogMessages;
use App\Services\ProductService;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $priceRaw = str_replace([' ', ','], ['', '.'], (string) $this->price);
        // Якщо термін створення не вказано, але обрано "можу виробити"
        if ($this->can_produce && empty($this->term_creation)) {
            $this->merge(['term_creation' => 7]); // Значення за замовчуванням
        }
        // Приведення чисел
        $this->merge([
            'price' => is_numeric($priceRaw) ? (float) $priceRaw : $this->price,
            'kind_product_id' => (int) $this->kind_product_id,
            'sub_kind_product_id' => (int) $this->sub_kind_product_id,
            'stock_balance' => (int) $this->stock_balance,
            'term_creation' => (int) $this->term_creation,
            'color_ids' => collect($this->color_ids)
                ->filter(fn ($id) => $id !== null && $id !== '')
                ->map(fn ($id) => (int) $id)
                ->values()
                ->all(),
            'brand_id' => $this->brand_id ? (int) $this->brand_id : NULL,
            'tags' => $this->tags !== null ? trim((string) $this->tags) : null,
            'social_links' => $this->social_links !== null ? trim((string) $this->social_links) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'kind_product_id' => 'required|integer|exists:kind_products,id',
            'sub_kind_product_id' => 'required|integer|exists:sub_kind_products,id',
            'stock_balance' => 'required|integer|min:0',
            'term_creation' => 'nullable|integer|min:0',
            'color_ids' => 'required|array|min:1',
            'color_ids.*' => 'integer|exists:colors,id',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'product_photo' => 'nullable|array|max:10',
            'product_photo.*' => [
                'image', // перевіряє, що файл дійсно зображення
                'mimes:jpg,jpeg,png,webp', // обмежує формати
            ],
            'content' => 'nullable|string|max:500',
            'tags' => 'nullable|string|max:255',
            'social_links' => 'nullable|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => UserAndLogMessages::ERROR_REQUIRED_FIELD,
            'title.string'   => UserAndLogMessages::ERROR_STRING_FIELD,
            'title.max'      => UserAndLogMessages::ERROR_MAX_STRING_FIELD,

            // price
            'price.required' => UserAndLogMessages::ERROR_REQUIRED_FIELD,
            'price.integer'  => UserAndLogMessages::ERROR_INTEGER_FIELD,
            'price.min'      => UserAndLogMessages::ERROR_MIN_STRING_FIELD,

            // kind_product_id
            'kind_product_id.required' => UserAndLogMessages::ERROR_REQUIRED_FIELD,
            'kind_product_id.integer'  => UserAndLogMessages::ERROR_INTEGER_FIELD,
            'kind_product_id.exists'   => UserAndLogMessages::ERROR_EXISTS_FIELD,

            // sub_kind_product_id
            'sub_kind_product_id.required' => UserAndLogMessages::ERROR_REQUIRED_FIELD,
            'sub_kind_product_id.integer'  => UserAndLogMessages::ERROR_INTEGER_FIELD,
            'sub_kind_product_id.exists'   => UserAndLogMessages::ERROR_EXISTS_FIELD,

            // stock_balance
            'stock_balance.required' => UserAndLogMessages::ERROR_REQUIRED_FIELD,
            'stock_balance.integer'  => UserAndLogMessages::ERROR_INTEGER_FIELD,
            'stock_balance.min'      => UserAndLogMessages::ERROR_MIN_STRING_FIELD,

            // term_creation
            'term_creation.integer' => UserAndLogMessages::ERROR_INTEGER_FIELD,
            'term_creation.min'     => UserAndLogMessages::ERROR_MIN_STRING_FIELD,

            // color_id
            'color_ids.required' => UserAndLogMessages::ERROR_REQUIRED_FIELD,
            'color_ids.array'  => UserAndLogMessages::ERROR_ARRAY_FIELD,
            'color_id.exists'   => UserAndLogMessages::ERROR_EXISTS_FIELD,

            // brand_id
            'brand_id.integer' => UserAndLogMessages::ERROR_INTEGER_FIELD,
            'brand_id.exists'  => UserAndLogMessages::ERROR_EXISTS_FIELD,

            // image
            'product_photo.array'    => UserAndLogMessages::ERROR_ARRAY_FIELD,
            'product_photo.min'      => UserAndLogMessages::ERROR_REQUIRED_FIELD,
            'product_photo.*.image'      => UserAndLogMessages::ERROR_INCORRECT_DATA,
            'product_photo.*.mimes'      => UserAndLogMessages::ERROR_INCORRECT_DATA,


            // content
            'content.string' => UserAndLogMessages::ERROR_STRING_FIELD,

            // tags
            'tags.string' => UserAndLogMessages::ERROR_STRING_FIELD,

            // social_links
            'social_links.string' => UserAndLogMessages::ERROR_STRING_FIELD,
        ];
    }
}
