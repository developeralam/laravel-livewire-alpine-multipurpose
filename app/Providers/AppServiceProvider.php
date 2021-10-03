<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

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
        Carbon::macro('toFormatedDate', function(){
            return $this->format('d-m-Y');
        });
        Carbon::macro('toFormatedTime', function(){
            return $this->format('h:m A');
        });
    }
}
