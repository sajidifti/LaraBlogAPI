<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleModel extends Command
{
    protected $signature   = 'make:module:model {module} {name}';
    protected $description = 'Create a new model inside a module';

    public function handle()
    {
        $module = ucfirst($this->argument('module'));
        $name   = ucfirst($this->argument('name'));

        $path = base_path("Modules/{$module}/Models/{$name}.php");

        if (File::exists($path)) {
            $this->error("Model {$name} already exists in {$module} module!");
            return;
        }

        File::put($path, <<<PHP
<?php

namespace Modules\\{$module}\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class {$name} extends Model
{
    protected \$guarded = ['id'];
}
PHP);

        $this->info("Model {$name} created in {$module} module.");
    }
}
