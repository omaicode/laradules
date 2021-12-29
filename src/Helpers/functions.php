<?php
use Illuminate\Support\Facades\File;

if(!function_exists('getModules')) {
    function getModules($name = null)
    {
        $modules = [];
        $folders = File::directories(base_path('/modules'));

        if(count($folders) > 0) {
            foreach($folders as $folder) {
                if(File::exists($folder.'/module.json')) {
                    $module = json_decode(File::get($folder.'/module.json'), true);

                    if($module['enable'] == true && $module['code'] != 'base') {
                        $modules[] = $module;
                    }
                }
            }
        }

        if($name) {
            $idx = array_search($name, array_column($modules, 'code'));
            $module = [];

            if($idx !== false) {
                $module = $modules[$idx];
            }

            return $module;
        }

        $modules = collect($modules)->sortBy('order')->values();
        return $modules;
    }
}

if(!function_exists('isModuleEnabled')) {
    function isModuleEnabled($name)
    {
        $enabled = false;
        $module = getModules($name);

        if(!empty($module)) {
            if(isset($module['enable']) && $module['enable'] == true) {
                $enabled = true;
            }
        }

        return $enabled;
    }
}

if (!function_exists('scan_folder')) {
    /**
     * @param string $path
     * @param array $ignoreFiles
     * @return array
     */
    function scan_folder($path, $ignoreFiles = [])
    {
        try {
            if (File::isDirectory($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..', '.DS_Store'], $ignoreFiles));
                natsort($data);
                return $data;
            }

            return [];
        } catch (Exception $exception) {
            return [];
        }
    }
}

if (!function_exists('scan_folder')) {
    function module_path($path = null)
    {
        return base_path('modules' . DIRECTORY_SEPARATOR . $path);
    }
}

if (!function_exists('get_file_data')) {
    /**
     * @param string $file
     * @param bool $convertToArray
     * @return array|bool|mixed|null
     */

    function get_file_data($file, $convertToArray = true)
    {
        $file = File::get($file);
        if (!empty($file)) {
            if ($convertToArray) {
                return json_decode($file, true);
            }

            return $file;
        }

        if (!$convertToArray) {
            return null;
        }

        return [];
    }
}