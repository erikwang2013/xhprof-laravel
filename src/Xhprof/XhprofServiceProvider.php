<?php

declare(strict_types=1);

namespace Aaron\Xhprof;

use Illuminate\Support\ServiceProvider;

class XhprofServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__.'/config/xhprof.php' => './config/xhprof.php',
            __DIR__.'/html'=>'./public/html',
            __DIR__.'/middleware'=>'./app/Http/Middleware'
        ]);
    }

    public function register()
    {
        $this->app->singleton('xhprof', function ($app) {
            return new Xhprof();
        });
    }



}