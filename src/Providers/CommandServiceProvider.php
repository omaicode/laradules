<?php

namespace Omaicode\Laradules\Providers;

use Omaicode\Laradules\Commands\ModuleCreateCommand;
use Omaicode\Laradules\Commands\ModuleListCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModuleListCommand::class,
                ModuleCreateCommand::class
            ]);
        }
    }
}
