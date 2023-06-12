<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    protected $namespaceApiTtaudit = 'App\Http\Controllers\Api\Ttaudit';
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        $this->mapGanamasApiRoutes();
        $this->mapTtauditApiRoutes();
    }

    /**
     * Mapeo de rutas para administración, las rutas están auth
     * @return void
     */
    protected function mapGanamasApiRoutes()
    {
        Route::prefix('api/v1/ganamas')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(function (){
                require (base_path('routes/api/ganamas/api-v1.php'));
            });
    }

    /**
     * Rutas para TTaudit
     * @return void
     */
    protected function mapTtauditApiRoutes()
    {
        Route::prefix('api/v1/ttaudit')
            ->middleware('api')
            ->namespace($this->namespaceApiTtaudit)
            ->group(function (){
                require (base_path('routes/api/ttaudit/audits-v1.php'));
            });

    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
