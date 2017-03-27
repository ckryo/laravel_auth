<?php

namespace Ckryo\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        Auth::extend('json', function($app, $name, array $config) use ($request) {
            return new JsonGuard(Auth::createUserProvider($config['provider']), $request);
        });
    }

}
