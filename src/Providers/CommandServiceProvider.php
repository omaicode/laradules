<?php

namespace Omaicode\Laradules\Providers;

use Omaicode\Laradules\Commands\PluginCreateCommand;
use Omaicode\Laradules\Commands\PluginListCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PluginListCommand::class,
                PluginCreateCommand::class
            ]);
        }
    }
}
