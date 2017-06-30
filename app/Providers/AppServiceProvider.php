<?php

namespace App\Providers;

use App\Line;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function($view) {
            if(auth()->check()) {
                $view->with('mylines', Line::where('user_id', auth()->user()->id)->orderBy('name')->get());
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
