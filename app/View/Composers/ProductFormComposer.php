<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    KindProduct,
    SubKindProduct,
    Color,
    Brand
};

class ProductFormComposer
{
    public function compose(View $view): void
    {
        $user = Auth::user();

        $view->with([
            'kindProducts' => KindProduct::whereNull('deleted_at')->get(),
            'subKindProducts' => SubKindProduct::whereNull('deleted_at')->get(),
            'colors' => Color::all(),

            // 👇 Бренди ТІЛЬКИ користувача
            'brands' => $user
                ? Brand::where('creator_id', $user->id)->get()
                : collect(),
        ]);
    }
}
