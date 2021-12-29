<?php

namespace Omaicode\Laradules\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class ModuleListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laradules:list:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all modules information';

    /**
     * Execute the console command.
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $header = [
            'Name',
            'Alias',
            'Version',
            'Provider',
            'Status',
            'Author',
        ];
        $result = [];

        $modules = scan_folder(module_path());
        if (!empty($modules)) {
            foreach ($modules as $module) {
                if (!File::exists(module_path($module . '/module.json'))) {
                    continue;
                }

                $content = get_file_data(module_path($module . '/module.json'));
                if (!empty($content)) {
                    $result[] = [
                        Arr::get($content, 'name'),
                        $module,
                        Arr::get($content, 'version'),
                        Arr::get($content, 'provider'),
                        Arr::get($content, 'author'),
                    ];
                }
            }
        }

        $this->table($header, $result);
    }
}
