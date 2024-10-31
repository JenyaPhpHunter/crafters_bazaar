<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|in:' . implode(',', array_keys(\App\Constants\OthersConstants::RATING)),
            'comment' => 'required|string|max:1000',
        ]);

        $review = new Review([
            'product_id' => $productId,
            'user_id' => $request->input('user_id'),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        $review->save();

        return redirect()->back()->with('success', 'Відгук успішно додано!');
    }

    public function getReviews($productId)
    {
        $product = Product::findOrFail($productId);
        $reviews = $product->reviews()->latest()->get();

        return view('product.reviews', compact('product', 'reviews'));
    }
}
