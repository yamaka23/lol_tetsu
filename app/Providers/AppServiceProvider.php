<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; //追記


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrap();//追記

        // Paginator::useBootstrapFive();    公式ドキュメント
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
