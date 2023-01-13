<?php

namespace App\Providers;

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
        //
//        // SOLO PARA SERVIDOR REMOTO-------------------------
//        $this->app->bind('path.public', function() {
//            return base_path('/../backoffice.ttaudit.com');
//        });
    }
}
