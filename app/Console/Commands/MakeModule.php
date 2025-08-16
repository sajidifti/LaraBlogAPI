<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModule extends Command
{
    protected $signature   = 'make:module {name} {--model=} {--migration} {--controller}';
    protected $description = 'Create a new module with optional controller, model, and migration';

    public function handle()
    {
        $name       = ucfirst($this->argument('name'));
        $modulePath = base_path("Modules/{$name}");

        if (File::exists($modulePath)) {
            $this->error("Module {$name} already exists!");
            return;
        }

        // Create base folders
        File::makeDirectory($modulePath, 0755, true);
        File::makeDirectory("{$modulePath}/Http/Controllers", 0755, true);
        File::makeDirectory("{$modulePath}/Http/Requests", 0755, true);
        File::makeDirectory("{$modulePath}/Http/Resources", 0755, true);
        File::makeDirectory("{$modulePath}/Models", 0755, true);
        File::makeDirectory("{$modulePath}/Routes", 0755, true);
        File::makeDirectory("{$modulePath}/Database/migrations", 0755, true);

        // Create api.php
        File::put("{$modulePath}/Routes/api.php", "<?php\n\nuse Illuminate\Support\Facades\Route;\n\n// Routes for {$name} module\n");

        $this->info("Module {$name} created.");

        // Optional: Create Controller
        if ($this->option('controller')) {
            $controllerName = $name . 'Controller';
            $controllerPath = "{$modulePath}/Http/Controllers/{$controllerName}.php";
            File::put($controllerPath, $this->controllerStub($name, $controllerName));
            $this->info("Controller {$controllerName} created.");
        }

        // Optional: Create Model
        if ($this->option('model')) {
            $modelName = ucfirst($this->option('model'));
            $modelPath = "{$modulePath}/Models/{$modelName}.php";
            File::put($modelPath, $this->modelStub($modelName));
            $this->info("Model {$modelName} created.");
        }

        // Optional: Create Migration
        if ($this->option('migration') && $this->option('model')) {
            $table         = strtolower(str_plural($this->option('model')));
            $migrationName = date('Y_m_d_His') . "_create_{$table}_table.php";
            $migrationPath = "{$modulePath}/Database/migrations/{$migrationName}";
            File::put($migrationPath, $this->migrationStub($table));
            $this->info("Migration created for {$table} table.");
        }
    }

    private function controllerStub($module, $controller)
    {
        return <<<PHP
<?php

namespace Modules\\{$module}\\Http\\Controllers;

use App\\Http\\Controllers\\Controller;
use Illuminate\\Http\\Request;

class {$controller} extends Controller
{
    public function index()
    {
        return response()->json(['message' => '{$module} index']);
    }
}
PHP;
    }

    private function modelStub($model)
    {
        return <<<PHP
<?php

namespace Modules\\{$model}\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class {$model} extends Model
{
    protected \$fillable = ['name'];
}
PHP;
    }

    private function migrationStub($table)
    {
        return <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('{$table}', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name');
            \$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('{$table}');
    }
};
PHP;
    }
}
