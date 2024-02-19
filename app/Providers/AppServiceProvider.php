<?php

namespace App\Providers;

use App\Models\CartItems;
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
        view()->composer(['admin.layouts.app', 'layouts.app'], function ($view) {
            $user = Auth::user();
            $products = Product::all();
            $kind_products = KindProduct::all();
            $sub_kind_products = SubKindProduct::all();
//            $sizes = Size::all();
//            $colors = Color::all();
            if($user){
                $user_products = Product::query()->where('user_id', $user->id)->get();
            } else {
                $user_products = [];
            }

            $statuses_products = StatusProduct::all();
            $statuses_orders = StatusOrder::all();
            $roles = Role::all();
            $orders = AdminOrder::all();
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
            $view->with('products', $products)
                ->with('kind_products', $kind_products)
                ->with('sub_kind_products', $sub_kind_products)
                ->with('roles', $roles)
                ->with('statuses_products', $statuses_products)
                ->with('statuses_orders', $statuses_orders)
                ->with('orders', $orders)
                ->with('cartItemsCount', $cartItemsCount)
                ->with('wishItemsCount', $wishItemsCount)
                ->with('user_products', $user_products)
//                ->with('sizes', $sizes)
//                ->with('colors', $colors)
                ->with('user', $user);
        });
    }
}
