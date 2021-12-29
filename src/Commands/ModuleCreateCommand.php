<?php

namespace Omaicode\Laradules\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use League\Flysystem\FileNotFoundException;

class ModuleCreateCommand extends BaseCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'laradules:create:module {name : The module that you want to create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a module in the /modules directory.';

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (!preg_match('/^[a-z0-9\-]+$/i', $this->argument('name'))) {
            $this->error('Only alphabetic characters are allowed.');
            return 1;
        }

        $module = strtolower($this->argument('name'));
        $location = base_path('modules/'.$module);

        if (File::isDirectory($location)) {
            $this->error('A module named [' . $module . '] already exists.');
            return 1;
        }

        $this->publishStubs($this->getStub(), $location);
        File::copy(__DIR__ . '/../../stubs/module.json', $location . '/module.json');
        $this->renameFiles($module, $location);
        $this->searchAndReplaceInFiles($module, $location);
        $this->removeUnusedFiles($location);
        $this->line('------------------');
        $this->line('<info>The module</info> <comment>' . $module . '</comment> <info>was created in</info> <comment>' . $location . '</comment><info>, customize it!</info>');
        $this->line('------------------');
        $this->call('cache:clear');

        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getStub(): string
    {
        return __DIR__ . '/../../stubs/module';
    }

    /**
     * @param string $location
     */
    protected function removeUnusedFiles(string $location)
    {
        File::delete($location . '/composer.json');
    }

    /**
     * {@inheritDoc}
     */
    public function getReplacements(string $replaceText): array
    {
        return [
            '{type}'     => 'plugin',
            '{types}'    => 'plugins',
            '{-module}'  => strtolower($replaceText),
            '{module}'   => Str::snake(str_replace('-', '_', $replaceText)),
            '{+module}'  => Str::camel($replaceText),
            '{modules}'  => Str::plural(Str::snake(str_replace('-', '_', $replaceText))),
            '{Modules}'  => ucfirst(Str::plural(Str::snake(str_replace('-', '_', $replaceText)))),
            '{-modules}' => Str::plural($replaceText),
            '{MODULE}'   => strtoupper(Str::snake(str_replace('-', '_', $replaceText))),
            '{Module}'   => ucfirst(Str::camel($replaceText)),
        ];
    }
}
