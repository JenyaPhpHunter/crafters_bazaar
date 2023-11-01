<?php

namespace App\Providers;

//use App\Models\Color;
use App\Models\KindProduct;
use App\Models\AdminOrder;
//use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
//use App\Models\Size;
use App\Models\StatusOrder;
use App\Models\StatusProduct;
use App\Models\SubKindProduct;
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
            $statuses_products = StatusProduct::all();
            $statuses_orders = StatusOrder::all();
            $roles = Role::all();
            $orders = AdminOrder::all();
            $view->with('products', $products)
                ->with('kind_products', $kind_products)
                ->with('sub_kind_products', $sub_kind_products)
                ->with('roles', $roles)
                ->with('statuses_products', $statuses_products)
                ->with('statuses_orders', $statuses_orders)
                ->with('orders', $orders)
//                ->with('sizes', $sizes)
//                ->with('colors', $colors)
                ->with('user', $user);
        });
    }
}
