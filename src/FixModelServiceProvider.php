<?php

namespace Paneidos\LaravelIdeHelper;

use Barryvdh\LaravelIdeHelper\Console\EloquentCommand;
use Barryvdh\LaravelIdeHelper\Console\GeneratorCommand;
use Illuminate\Support\ServiceProvider;

class FixModelServiceProvider extends ServiceProvider
{
    public function register() {
        $this->app->afterResolving(EloquentCommand::class, function ($resolved, $app) {
            /** @var EloquentCommand $resolved */
            $reflection = new \ReflectionClass($resolved);
            $property = $reflection->getProperty('files');
            $property->setAccessible(true);
            $property->setValue($resolved, $app->make(ReadOnlyFilesystem::class));
        });
        $this->app->afterResolving(GeneratorCommand::class, function ($resolved, $app) {
            /** @var GeneratorCommand $resolved */
            $reflection = new \ReflectionClass($resolved);
            $property = $reflection->getProperty('files');
            $property->setAccessible(true);
            $property->setValue($resolved, $app->make(ReadOnlyFilesystem::class, ['only' => base_path('vendor/*')]));
        });
    }
}
