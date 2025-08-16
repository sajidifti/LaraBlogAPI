<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleMigration extends Command
{
    protected $signature   = 'make:module:migration {module} {name}';
    protected $description = 'Create a new migration inside a module';

    public function handle()
    {
        $module    = ucfirst($this->argument('module'));
        $name      = $this->argument('name');
        $timestamp = date('Y_m_d_His');
        $filename  = "{$timestamp}_{$name}.php";

        $path = base_path("Modules/{$module}/Database/migrations/{$filename}");

        File::put($path, <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('{$this->guessTableName($name)}', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name');
            \$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('{$this->guessTableName($name)}');
    }
};
PHP);

        $this->info("Migration {$filename} created in {$module} module.");
    }

    private function guessTableName($name)
    {
        return Str::plural(Str::snake(str_replace('create_', '', str_replace('_table', '', $name))));
    }
}
