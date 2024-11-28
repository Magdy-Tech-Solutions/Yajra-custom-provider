<?php

namespace Custom\Yajra;

use Illuminate\Support\ServiceProvider;

class YajraServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'custom-yajra');
    }

    public function register() {}
}
