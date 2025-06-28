<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'sub_kind_product_id' => 'nullable|integer|exists:sub_kind_products,id',
            'content' => 'nullable|string',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'links_networks' => 'nullable|string',
            'price' => 'nullable|integer|min:0',
            'discount' => 'nullable|integer|min:0',
            'stock_balance' => 'nullable|integer|min:0',
            'color_id' => 'nullable|integer|exists:colors,id',
            'term_creation' => 'nullable|integer|min:0',
            'status_product_id' => 'required|integer|exists:status_products,id',
            'user_id' => 'required|integer|exists:users,id',
            'new' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'active' => 'nullable|boolean',
            'date_put_up_for_sale' => 'nullable|date',
            'date_approve_sale' => 'nullable|date',
            'admin_id' => 'nullable|integer|exists:users,id',
            'additional_information' => 'nullable|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Тут тільки підготовка даних, без валідації
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

        // Якщо термін створення не вказано, але обрано "можу виробити"
        if ($this->can_produce && empty($this->term_creation)) {
            $this->merge(['term_creation' => 7]); // Значення за замовчуванням
        }

        // Приведення чисел
        $this->merge([
            'price' => (int) $this->price,
            'discount' => $this->discount ? (int) $this->discount : 0,
        ]);
    }
}
