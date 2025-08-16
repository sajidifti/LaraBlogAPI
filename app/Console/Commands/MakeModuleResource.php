<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleResource extends Command
{
    protected $signature   = 'make:module:resource {module} {name} {--collection}';
    protected $description = 'Create a new API Resource inside a module';

    public function handle()
    {
        $module       = ucfirst($this->argument('module'));
        $name         = ucfirst($this->argument('name'));
        $isCollection = $this->option('collection');

        $dir = base_path("Modules/{$module}/Http/Resources");

        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $path = "{$dir}/{$name}.php";

        if (File::exists($path)) {
            $this->error("Resource {$name} already exists in {$module} module!");
            return;
        }

        File::put($path, $isCollection ? $this->collectionStub($module, $name) : $this->resourceStub($module, $name));

        $this->info("Resource {$name} created in {$module} module.");
    }

    private function resourceStub($module, $name)
    {
        return <<<PHP
<?php

namespace Modules\\{$module}\\Http\\Resources;

use Illuminate\\Http\\Resources\\Json\\JsonResource;

class {$name} extends JsonResource
{
    public function toArray(\$request)
    {
        return [
            'id' => \$this->id,
            'created_at' => \$this->created_at?->toDateTimeString(),
            'updated_at' => \$this->updated_at?->toDateTimeString(),
        ];
    }
}
PHP;
    }

    private function collectionStub($module, $name)
    {
        return <<<PHP
<?php

namespace Modules\\{$module}\\Http\\Resources;

use Illuminate\\Http\\Resources\\Json\\ResourceCollection;

class {$name} extends ResourceCollection
{
    public function toArray(\$request)
    {
        return [
            'data' => \$this->collection,
            'meta' => [
                'count' => \$this->count(),
            ],
        ];
    }
}
PHP;
    }
}
