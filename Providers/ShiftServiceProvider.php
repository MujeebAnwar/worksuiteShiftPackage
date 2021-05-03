<?php

namespace Modules\Shifts\Providers;

use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use  Modules\Shifts\Library\Shift;
use  Modules\Shifts\Models\AssignShifts;

class ShiftServiceProvider extends ServiceProvider
{


    public function boot()
    {



        $this->registerTranslations();
        $this->registerConfig();
        $this->loadViews();
        $this->loadRoutesFrom(module_path('Shifts','Routes/web.php'));
        $this->loadMigrationsFrom(module_path('Shifts', 'Database/Migrations'));
        $this->registerMigrations();


    }
    public function register()
    {
        $this->app->bind('shift',function ($app){

            return new Shift();

        });
    }

    /**
     * Register Config File
     */
    private function registerConfig()
    {
        $this->publishes([
            module_path('Shifts','Config/shift.php') =>config_path('shift.php'),
        ], 'shifts-config');
        $this->mergeConfigFrom(
            module_path('Shifts', 'Config/shift.php'), 'shifts'
        );

    }


    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/shifts');


        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'shifts');
        } else {

            $this->loadTranslationsFrom(module_path('Shifts', 'Resources/lang'), 'shifts');
        }

    }

    /**
     * Register Views
     */

    private function loadViews()
    {


        $viewPath = resource_path('views/modules/shifts');

        $sourcePath = module_path('Shifts', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'shifts-views');
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/shifts';
        }, \Config::get('view.paths')), [$sourcePath]), 'shifts');


    }

    /**
     * Register Migrations
     */

    private function registerMigrations()
    {

        $this->publishes([module_path('Shifts','Database/Migrations')=> database_path('migrations')],'shifts-migrations');

    }
}