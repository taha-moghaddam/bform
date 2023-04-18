<?php

namespace Bikaraan\BForm;

use Illuminate\Support\ServiceProvider;

class BFormServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(BForm $extension)
    {
        if (!BForm::boot()) {
            return;
        }

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'bform');

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'bform');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/bform')],
                'bform'
            );
        }

        $this->app->booted(function () {
            BForm::routes(__DIR__ . '/../routes/web.php');
        });
    }
}
