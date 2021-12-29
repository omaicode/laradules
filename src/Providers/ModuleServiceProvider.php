<?php
namespace Omaicode\Laradules\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $modules = getModules();

        foreach($modules as $module) {
            if(isset($module['provider'])) {
                $this->app->register($module['provider']);
            }
        }
    }

    public function boot()
    {
        $this->app->register(CommandServiceProvider::class);
    }
}