<?php

namespace App\Providers;

use App\Models\AdminOrder;
use App\Models\CartItems;
use App\Models\ForumCategory;
use App\Models\KindProduct;
use App\Models\Product;
use App\Models\Role;
use App\Models\StatusOrder;
use App\Models\StatusProduct;
use App\Models\User;
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
            'include.footer',
        ], function ($view) {
            $user = Auth::user();

//            $query_users = User::query()->whereNull('deleted_at');
//            $users = $query_users->get();
//            $sellers_buyers = $query_users->whereIn('role_id', [5,6])->get();
//            $sellers = $query_users->where('category_user_id', 3)->get();
//            $buyers = $query_users->where('category_user_id', 4)->get();
            $orders = AdminOrder::all();
            $statuses_orders = StatusOrder::all();
            $statuses_products = StatusProduct::all();
            $roles = Role::all();
            // Основний запит для отримання всіх активних та неделеційованих KindProduct
            $baseQuery = KindProduct::whereNull('deleted_at')
                ->with('sub_kind_products');
            $all_kind_products = $baseQuery->get();
            $header_kind_products = $baseQuery->whereHas('sub_kind_products.products', function ($query) {
                $query->where('status_product_id', 3);
            })
                ->with(['sub_kind_products' => function ($query) {
                    $query->whereHas('products', function ($query) {
                        $query->where('status_product_id', 3);
                    });
                }])
                ->get();
            $products_query = Product::whereNull('deleted_at');
            $products = $products_query->get();
            if($user){
                $user_products = $products_query->where('user_id', $user->id)->get();
                $roles = Role::where('id', '>=', $user->role_id)->get();
            } else {
                $user_products = collect();
            }
            $wishItemsCount = 0;
            if ($user) {
                $cartItemsCount = CartItems::query()
                    ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
                    ->where('carts.user_id', $user->id)
                    ->where('carts.active', 1)
                    ->sum('cart_items.quantity');
                $wishItemsCount = WishItems::query()
                    ->where('user_id', $user->id)
                    ->where('active', 1)
                    ->count();
            }         elseif (request()->cookie('user_id') != NULL) {
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
                $cart = session()->get('cart', []);
                $cartItemsCount = array_sum(array_column($cart, 'quantity'));
            }
            $forum_categories = ForumCategory::query()->with('forum_sub_categories')->get();
            $title_list = Product::query()
                ->where('status_product_id', 3)
//                ->where('new', 1)
                ->latest()
                ->limit(10)
                ->get();
            $view->with('header_kind_products', $header_kind_products)
                ->with('all_kind_products', $all_kind_products)
                ->with('roles', $roles)
                ->with('statuses_products', $statuses_products)
                ->with('cartItemsCount', $cartItemsCount)
                ->with('wishItemsCount', $wishItemsCount)
                ->with('user_products', $user_products)
                ->with('user', $user)
                ->with('categories', $forum_categories)
                ->with('products', $products)
//                ->with('users', $users)
                ->with('orders', $orders)
                ->with('statuses_orders', $statuses_orders)
                ->with('title_list', $title_list);
            if ($user){
                return redirect(route('welcome'));
            }
        });
    }
}
