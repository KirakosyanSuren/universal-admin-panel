<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ModuleStructure extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Create a module with full structure, using global Core and Shared';

    public function handle()
    {
        $module = $this->argument('name');
        $base = app_path("Modules/{$module}");

        $globalFolders = [
            'Core',
            'Shared/DTO',
            'Shared/Enums',
            'Shared/Services',
            'Shared/Helpers',
        ];

        foreach ($globalFolders as $folder) {
            $path = app_path($folder);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
        }

        $folders = [
            'Controllers',
            'Models',
            'Repositories/Interfaces',
            'Services',
            'DTO',
            'Requests',
            'Policies',
            'Routes',
            'Database/Migrations',
        ];

        foreach ($folders as $folder) {
            $path = $base . '/' . $folder;
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
        }

        $files = [
            "Controllers/{$module}Controller.php",
            "Models/{$module}.php",
            "Services/{$module}Service.php",
            "Repositories/{$module}Repository.php",
            "Repositories/Interfaces/{$module}RepositoryInterface.php",
            "DTO/{$module}DTO.php",
            "Requests/Store{$module}Request.php",
            "Requests/Update{$module}Request.php",
            "Policies/{$module}Policy.php",
            "Routes/web.php",
            "Routes/api.php",
        ];

        foreach ($files as $file) {
            $filePath = $base . '/' . $file;
            if (!File::exists($filePath)) {
                File::put($filePath, "<?php\n\nnamespace App\\Modules\\{$module};\n");
            }
        }

        $this->info("Senior module {$module} created successfully with global Core and Shared!");
    }
}
