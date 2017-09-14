<?php

namespace Paneidos\LaravelIdeHelper;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class FixModelDocBlock extends Command
{
    const BAD = "\n * @mixin \Illuminate\Database\Eloquent\Builder\n * @mixin \Illuminate\Database\Query\Builder\n";
    const GOOD = "\n * @mixin \Eloquent\n * @mixin \Illuminate\Database\Eloquent\Builder\n";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ide-helper:fix-model-docblock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $class = new \ReflectionClass(Model::class);
        $docBlock = $class->getDocComment();
        if (!str_contains($docBlock, static::BAD)) {
            return 0;
        }
        $newDocBlock = str_replace(static::BAD, static::GOOD, $docBlock);
        $filename = $class->getFileName();
        $source = str_replace($docBlock, $newDocBlock, file_get_contents($filename));
        file_put_contents($filename, $source);
        return 0;
    }
}
