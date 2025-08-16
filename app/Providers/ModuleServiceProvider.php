<?php
namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registering module routes with auto-prefix
        foreach (glob(base_path('Modules/*/Routes/api.php')) as $routeFile) {
            if (is_file($routeFile)) {
                $moduleName   = basename(dirname(dirname($routeFile)));
                $modulePrefix = Str::kebab($moduleName);

                Route::prefix("api/{$modulePrefix}")
                    ->middleware('api')
                    ->group($routeFile);
            }
        }

        // Registering module migrations
        foreach (glob(base_path('Modules/*/Database/migrations')) as $migrationPath) {
            if (is_dir($migrationPath)) {
                $this->loadMigrationsFrom($migrationPath);
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
