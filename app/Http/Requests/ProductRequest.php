<?php

namespace App\Http\Requests;

use App\Constants\UserAndLogMessages;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    private bool $prepared = false;

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'title'               => 'Назва',
            'price'               => 'Вартість',
            'kind_product_id'     => 'Вид товару',
            'sub_kind_product_id' => 'Підвид товару',
            'stock_balance'       => 'Кількість',
            'term_creation'       => 'Термін виготовлення',
            'color_ids'           => 'Кольори',
            'brand_id'            => 'Бренд',
            'product_photo'       => 'Фото товару',
            'content'             => 'Опис',
            'tags'                => 'Теги',
            'social_links'        => 'Соціальні мережі',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->prepared) return;
        $this->prepared = true;

        $priceRaw = str_replace([' ', ','], ['', '.'], (string) $this->price);

        if ($this->can_produce && empty($this->term_creation)) {
            $this->merge(['term_creation' => 7]);
        }

        $this->merge([
            'price'               => is_numeric($priceRaw) ? (float) $priceRaw : $this->price,
            'kind_product_id'     => $this->kind_product_id     ? (int) $this->kind_product_id     : null,
            'sub_kind_product_id' => $this->sub_kind_product_id ? (int) $this->sub_kind_product_id : null,
            'stock_balance'       => (int) $this->stock_balance,
            'term_creation'       => (int) $this->term_creation,
            'color_ids'           => collect($this->color_ids)
                ->filter(fn ($id) => $id !== null && $id !== '')
                ->map(fn ($id) => (int) $id)
                ->values()
                ->all(),
            'brand_id'            => $this->brand_id ? (int) $this->brand_id : null,
            'tags'                => $this->tags !== null ? trim((string) $this->tags) : null,
            'social_links'        => $this->social_links !== null ? trim((string) $this->social_links) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:1|max:42949672',
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
            'title.required'              => 'Поле ":attribute" обов\'язкове для заповнення',
            'price.required'              => 'Поле ":attribute" обов\'язкове для заповнення',
            'kind_product_id.required'    => 'Поле ":attribute" обов\'язкове для заповнення',
            'kind_product_id.exists'      => 'Обраний ":attribute" не існує',
            'sub_kind_product_id.required' => 'Поле ":attribute" обов\'язкове для заповнення',
            'sub_kind_product_id.exists'  => 'Обраний ":attribute" не існує',
            'stock_balance.required'      => 'Поле ":attribute" обов\'язкове для заповнення',
            'color_ids.required'          => 'Поле ":attribute" обов\'язкове для заповнення',

            'title.string'                => 'Поле ":attribute" має бути текстом',
            'title.max'                   => 'Поле ":attribute" не може бути довшим за 255 символів',
            'price.numeric'               => 'Поле ":attribute" має бути числом',
            'price.min'                   => 'Поле ":attribute" має бути більше 0',
            'price.max'                   => 'Поле ":attribute" не може перевищувати 42 949 672 грн',
            'stock_balance.integer'       => 'Поле ":attribute" має бути цілим числом',
            'stock_balance.min'           => 'Поле ":attribute" не може бути від\'ємним',
            'color_ids.array'             => 'Поле ":attribute" має бути масивом',
            'product_photo.array'         => 'Поле ":attribute" має бути масивом',
            'product_photo.*.image'       => 'Файл у полі ":attribute" має бути зображенням',
            'product_photo.*.mimes'       => 'Файл у полі ":attribute" має бути у форматі jpg, jpeg, png або webp',
        ];
    }
}
