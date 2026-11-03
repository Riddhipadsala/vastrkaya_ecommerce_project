<?php

namespace App\Providers;

use App\Models\MainCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.navbar',function($view) {
            $main_category = MainCategory::with(['categories' => function ($q) {
                $q->where('status',1);
            }])->get();

            $view->with('main_category', $main_category);
        });
    }
}
