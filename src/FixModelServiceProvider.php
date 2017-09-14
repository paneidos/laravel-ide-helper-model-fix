<?php

namespace Paneidos\LaravelIdeHelper;

use Illuminate\Support\ServiceProvider;

class FixModelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            'command.ide-helper.fix-model-docblock',
            function ($app) {
                return new FixModelDocBlock();
            }
        );

        $this->commands('command.ide-helper.fix-model-docblock');
    }
}
