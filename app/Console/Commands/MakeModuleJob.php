<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleJob extends Command
{
    protected $signature   = 'make:module:job {module} {name}';
    protected $description = 'Create a new Job class inside a module';

    public function handle()
    {
        $module = ucfirst($this->argument('module'));
        $name   = ucfirst($this->argument('name'));

        $dir  = base_path("Modules/{$module}/Jobs");
        $path = "{$dir}/{$name}.php";

        if (File::exists($path)) {
            $this->error("Job {$name} already exists in {$module} module!");
            return;
        }

        // ensure directory exists
        File::ensureDirectoryExists($dir);

        File::put($path, <<<PHP
<?php

namespace Modules\\{$module}\\Jobs;

use Illuminate\\Bus\\Queueable;
use Illuminate\\Contracts\\Queue\\ShouldQueue;
use Illuminate\\Foundation\\Bus\\Dispatchable;
use Illuminate\\Queue\\InteractsWithQueue;
use Illuminate\\Queue\\SerializesModels;

class {$name} implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Job logic here
    }
}
PHP);

        $this->info("Job {$name} created in {$module} module.");
    }
}
