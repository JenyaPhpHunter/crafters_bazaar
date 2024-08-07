<?php

namespace App\Providers;

use App\Models\CartItems;
use App\Models\ForumCategory;
use App\Models\ForumSubCategory;
use App\Models\KindProduct;
use App\Models\AdminOrder;
use App\Models\Product;
use App\Models\Role;
use App\Models\StatusOrder;
use App\Models\StatusProduct;
use App\Models\SubKindProduct;
use App\Models\WishItems;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $topMenu;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'include.header-section',
            'admin.include.header-section',
            'include.header-sticky-section',
            'admin.include.header-sticky-section',
        ], function ($view) {
            $user = Auth::user();
            $header_kind_products = KindProduct::where('del', 0)
                ->where('active', 1)
                ->with('sub_kind_products')
                ->get();
            if($user){
                $user_products = Product::query()->where('user_id', $user->id)->get();
            } else {
                $user_products = collect();
            }

            $statuses_products = StatusProduct::all();
            $roles = Role::all();
            if($user){
                $cartItemsCount = CartItems::query()
                    ->join('carts', 'cart_items.cart_id', '=', 'carts.id')->with('product')
                    ->where('carts.user_id', $user->id)
                    ->where('carts.active', 1)
                    ->count();
                $wishItemsCount = WishItems::query()
                    ->where('user_id', $user->id)
                    ->where('active', 1)
                    ->count();
            } elseif (request()->cookie('user_id') != NULL) {
                $user_id = request()->cookie('user_id');
                $cartItemsCount = CartItems::query()
                    ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
                    ->where('carts.user_id', $user_id)
                    ->where('carts.active', 1)
                    ->sum('cart_items.quantity');
                $wishItemsCount = WishItems::query()
                    ->where('user_id', $user_id)
                    ->where('active', 1)
                    ->count();
            } else {
                $cartItemsCount = 0;
                $wishItemsCount = 0;
            }
            $forum_categories = ForumCategory::query()->with('forum_sub_categories')->get();
            $title_list = Product::query()
                ->where('status_product_id', 3)
                ->where('new', 1)
                ->latest()
                ->limit(10)
                ->get();

            $view->with('header_kind_products', $header_kind_products)
            ->with('roles', $roles)
                ->with('statuses_products', $statuses_products)
                ->with('cartItemsCount', $cartItemsCount)
                ->with('wishItemsCount', $wishItemsCount)
                ->with('user_products', $user_products)
                ->with('user', $user)
                ->with('categories', $forum_categories)
                ->with('title_list', $title_list);
        });
    }
}
