<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleRequest extends Command
{
    protected $signature   = 'make:module:request {module} {name}';
    protected $description = 'Create a FormRequest inside a module';

    public function handle()
    {
        $module = ucfirst($this->argument('module'));
        $name   = ucfirst($this->argument('name'));

        $dir = base_path("Modules/{$module}/Http/Requests");

        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $path = "{$dir}/{$name}.php";

        if (File::exists($path)) {
            $this->error("Request {$name} already exists in {$module} module!");
            return;
        }

        File::put($path, $this->stub($module, $name));

        $this->info("Request {$name} created in {$module} module.");
    }

    private function stub($module, $name)
    {
        return <<<PHP
<?php

namespace Modules\\{$module}\\Http\\Requests;

use Illuminate\Foundation\Http\FormRequest;

class {$name} extends FormRequest
{
    public function authorize()
    {
        return true; // Change to your authorization logic if needed
    }

    public function rules()
    {
        return [
            // Define validation rules here
        ];
    }
}
PHP;
    }
}
