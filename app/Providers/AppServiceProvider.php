<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\CartCount;
use App\Models\Config;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
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
        Livewire::component('cart-count', CartCount::class);
        
        // Share config data with all views
        View::composer('*', function ($view) {
            $config = Config::first();
            $view->with('config', $config);
        });
    }
}
