<?php

namespace Richardds\ServerAdmin\Providers;

use App;
use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Richardds\ServerAdmin\Core\CommandExecuter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);

            if (env('DEBUGBAR_ENABLED', false)) {
                $this->app->register(DebugbarServiceProvider::class);
            }
        }

        App::bind('Execute', function () {
            return new CommandExecuter();
        });
    }
}
