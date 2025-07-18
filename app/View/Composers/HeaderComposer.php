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
        $baseQuery = KindProduct::whereNull('deleted_at')->with('sub_kind_products');
        $all_kind_products = $baseQuery->get();

        $header_kind_products = $baseQuery->whereHas('sub_kind_products.products', function ($query) {
            $query->where('status_product_id', 3);
        })->with(['sub_kind_products' => function ($query) {
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
        $title_list = Product::where('status_product_id', 3)->latest()->limit(10)->get();

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
            'title_list'
        ));

        $view->with('orders', AdminOrder::all());
        $view->with('statuses_orders', StatusOrder::all());
        $view->with('statuses_products', StatusProduct::all());
    }
}
