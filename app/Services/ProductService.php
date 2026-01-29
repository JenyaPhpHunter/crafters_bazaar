<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function create(array $data): Product
    {
        $product = Product::create([
            'title' => $data['title'],
            'price' => $data['price'], // mutator зробить копійки
            'sub_kind_product_id' => $data['sub_kind_product_id'],
            'stock_balance' => $data['stock_balance'],
            'term_creation' => $data['term_creation'] ?? null,
            'brand_id' => $data['brand_id'] ?? null,

            'content' => $data['content'] ?? null,
            'tags' => $data['tags'] ?? null,
            'social_links' => $data['social_links'] ?? null,

            'additional_information' => $data['additional_information'] ?? null,
            'creator_id' => auth()->id(),
        ]);

        if (!empty($data['color_ids'])) {
            $product->colors()->sync($data['color_ids']);
        }

        return $product;
    }
}
