<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        foreach (glob(base_path('Modules/*/Routes/api.php')) as $routeFile) {
            $this->loadRoutesFrom($routeFile);
        }

        foreach (glob(base_path('Modules/*/Database/migrations')) as $migrationPath) {
            $this->loadMigrationsFrom($migrationPath);
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
