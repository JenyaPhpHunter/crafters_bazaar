<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    KindProduct,
    Product,
    CartItems,
    WishItems,
    Role,
    ForumCategory,
    AdminOrder,
    StatusOrder,
    StatusProduct
};

class HeaderComposer
{
    public function compose(View $view): void
    {
        $user = Auth::user();

        // Категорії
        $baseQuery = KindProduct::whereNull('deleted_at')->with('subKindProducts');
        $all_kind_products = $baseQuery->get();

        $header_kind_products = $baseQuery->whereHas('subKindProducts.products', function ($query) {
            $query->where('status_product_id', 3);
        })->with(['subKindProducts' => function ($query) {
            $query->whereHas('products', function ($query) {
                $query->where('status_product_id', 3);
            });
        }])->get();

        // Продукти
        $products = Product::whereNull('deleted_at')->get();
        $user_products = $user ? Product::where('creator_id', $user->id)->get() : collect();
        $roles = $user ? Role::where('id', '>=', $user->role_id)->get() : Role::all();

        // Кошик і бажане
        $cartItemsCount = 0;
        $wishItemsCount = 0;

        if ($user) {
            $cartItemsCount = CartItems::join('carts', 'cart_items.cart_id', '=', 'carts.id')
                ->where('carts.user_id', $user->id)
                ->where('carts.active', 1)
                ->sum('cart_items.quantity');

            $wishItemsCount = WishItems::where('user_id', $user->id)->where('active', 1)->count();
        } elseif (request()->cookie('user_id')) {
            $user_id = request()->cookie('user_id');

            $cartItemsCount = CartItems::join('carts', 'cart_items.cart_id', '=', 'carts.id')
                ->where('carts.user_id', $user_id)
                ->where('carts.active', 1)
                ->sum('cart_items.quantity');

            $wishItemsCount = WishItems::where('user_id', $user_id)->where('active', 1)->count();
        } else {
            $cart = session()->get('cart', []);
            $cartItemsCount = array_sum(array_column($cart, 'quantity'));
        }

        // Інше
        $forum_categories = ForumCategory::with('forum_sub_categories')->get();
        $header_products = Product::query()
            ->with([
                'productPhotos'             => fn($q) => $q->where('is_main', true),
                'discounts'                 => fn($q) => $q->active()->where('type', 'product'),
                'subKindProduct.discounts'  => fn($q) => $q->active()->where('type', 'category'),
            ])
            ->where('status_product_id', '>', 2)
            ->whereNotNull('date_approve_sale')
            ->orderBy('date_approve_sale', 'desc')
            ->limit(12)
            ->get();

        $view->with(compact(
            'header_kind_products',
            'all_kind_products',
            'roles',
            'cartItemsCount',
            'wishItemsCount',
            'user_products',
            'user',
            'forum_categories',
            'products',
            'header_products',
        ));

        $view->with('orders', AdminOrder::all());
        $view->with('statuses_orders', StatusOrder::all());
        $view->with('statuses_products', StatusProduct::all());
    }
}
