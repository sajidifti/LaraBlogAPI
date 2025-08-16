<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleController extends Command
{
    protected $signature   = 'make:module:controller {module} {name}';
    protected $description = 'Create a new controller inside a module';

    public function handle()
    {
        $module = ucfirst($this->argument('module'));
        $name   = ucfirst($this->argument('name'));

        $path = base_path("Modules/{$module}/Http/Controllers/{$name}.php");

        if (File::exists($path)) {
            $this->error("Controller {$name} already exists in {$module} module!");
            return;
        }

        File::put($path, <<<PHP
<?php

namespace Modules\\{$module}\\Http\\Controllers;

use App\\Http\\Controllers\\Controller;
use Illuminate\\Http\\Request;

class {$name} extends Controller
{
    public function index()
    {
        return response()->json(['message' => '{$module} {$name} index']);
    }
}
PHP);

        $this->info("Controller {$name} created in {$module} module.");
    }
}
