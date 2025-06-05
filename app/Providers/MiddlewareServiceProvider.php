<?php

namespace App\Providers;

use App\Http\Middleware\VerifyCarToken;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $router = $this->app->get('router');
        $router->aliasMiddleware('car.token', VerifyCarToken::class);
    }

    public function register()
    {
        //
    }
}