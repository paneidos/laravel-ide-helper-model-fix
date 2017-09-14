# Laravel IDE helper Model docblock fix

This will modify the docblock in `Illuminate\Database\Eloquent\Model`.
To be used in conjunction with [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper).

## Installation

`composer require --dev paneidos/laravel-ide-helper-model-fix`

## Run the command

`php artisan ide-helper:fix-model-docblock`

## Add it your composer.json

If you're using laravel-ide-helper, you should at it right after the other ide-helper commands

```json
{
    "scripts": {
        "post-update-cmd": [
            "Illuminate\\Foundation\\ComposerScripts::postUpdate",
            "@php artisan ide-helper:generate",
            "@php artisan ide-helper:meta",
            "@php artisan ide-helper:fix-model-docblock"
        ]
    }
}
```
