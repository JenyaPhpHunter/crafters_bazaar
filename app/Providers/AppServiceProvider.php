<?php

namespace App\Providers;

use App\Models\KindProduct;
use App\Models\Role;
use App\Models\StatusProduct;
use App\Models\SubKindProduct;
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
        view()->composer('admin.layouts.app', function ($view) {
            $kind_products = KindProduct::all();
            $sub_kind_products = SubKindProduct::all();
            $statuses_products = StatusProduct::all();
            $roles = Role::all();
            $view->with('kind_products', $kind_products)
                ->with('sub_kind_products', $sub_kind_products)
                ->with('roles', $roles)
                ->with('statuses_products', $statuses_products);
        });
//        view()->composer('*', function ($view) {
//            if (!isset($this->topMenu)) {
//                // выборка меню из базы
//                $this->topMenu = "При першій покупці знижка 10%";
//            }
//            $view->with(['topMenu' => $this->topMenu]);
//        });
    }
}
