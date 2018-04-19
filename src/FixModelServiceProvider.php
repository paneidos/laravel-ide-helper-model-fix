<?php

namespace Paneidos\LaravelIdeHelper;

use Illuminate\Support\ServiceProvider;

class FixModelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->when(\Barryvdh\LaravelIdeHelper\Console\EloquentCommand::class)
            ->needs(\Illuminate\Filesystem\Filesystem::class)
            ->give(ReadOnlyFilesystem::class);

        $this->app->when(\Barryvdh\LaravelIdeHelper\Console\GeneratorCommand::class)
            ->needs(\Illuminate\Filesystem\Filesystem::class)
            ->give(function () {
                $this->app->make(ReadOnlyFilesystem::class, ['only' => base_path('vendor/*')]);
            });
    }
}
