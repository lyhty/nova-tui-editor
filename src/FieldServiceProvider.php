<?php

namespace Lyhty\NovaTuiEditor;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/nova-tui-editor.php' => config_path('nova-tui-editor.php'),
        ], 'config');

        Nova::serving(function (ServingNova $event) {
            Nova::mix('nova-tui-editor', __DIR__.'/../dist/mix-manifest.json');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-tui-editor.php', 'nova-tui-editor');
    }
}
