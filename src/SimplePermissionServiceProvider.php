<?php

namespace Lcloss\SimplePermission;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Lcloss\SimplePermission\Http\Middleware\AuthGates;
use Lcloss\SimplePermission\Http\Livewire\UsersList;
use Lcloss\SimplePermission\Http\Livewire\RolesList;
use Lcloss\SimplePermission\Http\Livewire\PermissionsList;
use Livewire\Livewire;

class SimplePermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $migrations = [
            'create_permissions_table' =>  date('Y_m_d_Hi', time()) . '01_create_permissions_table.php',
            'create_roles_table' =>  date('Y_m_d_Hi', time()) . '02_create_roles_table.php',
            'create_role_user_table' =>  date('Y_m_d_Hi', time()) . '03_create_role_user_table.php',
            'create_permission_role_table' =>  date('Y_m_d_Hi', time()) . '04_create_permission_role_table.php',
        ];

        /* Retrieve migrations */
        foreach( glob(database_path('migrations/') . '*.php') as $file ) {
            $filename = basename( $file );
            if ( preg_match('/^\d{4}_\d{2}_\d{2}_\d{6}_create_permissions_table\.php$/', $filename, $matches) ) {
                $migrations['create_permissions_table'] = $filename;
            }
            if ( preg_match('/^\d{4}_\d{2}_\d{2}_\d{6}_create_roles_table\.php$/', $filename, $matches) ) {
                $migrations['create_roles_table'] = $filename;
            }
            if ( preg_match('/^\d{4}_\d{2}_\d{2}_\d{6}_create_role_user_table\.php$/', $filename, $matches) ) {
                $migrations['create_role_user_table'] = $filename;
            }
            if ( preg_match('/^\d{4}_\d{2}_\d{2}_\d{6}_create_permission_role_table\.php$/', $filename, $matches) ) {
                $migrations['create_permission_role_table'] = $filename;
            }
        }

        /* Register routes */
        Route::prefix('simple-permission')
            ->as('simple-permission.')
            ->middleware( config('simple-permission.middleware') )
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            });

        /* Register views */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'simple-permission');

        if ($this->app->runningInConsole()) {
            /* Register assets */
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('simple-permission'),
            ], 'simple-permission-assets');

            /* Register config */
            $this->publishes([
                __DIR__.'/../config/simple-permission.php' => config_path('simple-permission.php'),
            ], 'simple-permission-config');

            /* Register migrations */

            /* Load migrations from package */
            // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            /* Publish migrations to application */
            $this->publishes([
                __DIR__ . '/../database/migrations/2023_08_16_211854_create_permissions_table.php' =>
                database_path('migrations/' . $migrations['create_permissions_table']),
                __DIR__ . '/../database/migrations/2023_08_16_211903_create_roles_table.php' =>
                database_path('migrations/' . $migrations['create_roles_table']),
                __DIR__ . '/../database/migrations/2023_08_16_225711_create_role_user_table.php' =>
                database_path('migrations/' . $migrations['create_role_user_table']),
                __DIR__ . '/../database/migrations/2023_08_17_124216_create_permission_role_table.php' =>
                database_path('migrations/' . $migrations['create_permission_role_table']),
            ], 'migrations');

            /* Register seeds */
            /* Publish seeds to application */
            $this->publishes([
                __DIR__ . '/../database/seeders/SimplePermissionPermissionSeeder.php' =>
                database_path('seeders/SimplePermissionPermissionSeeder.php'),
                __DIR__ . '/../database/seeders/SimplePermissionRoleSeeder.php' =>
                database_path('seeders/SimplePermissionRoleSeeder.php'),
                __DIR__ . '/../database/seeders/SimplePermissionSeeder.php' =>
                database_path('seeders/SimplePermissionSeeder.php'),
            ], 'seeders');

            /* Register commands */
//            $this->commands([
//                MakePermissionCommand::class,
//            ]);
        }

        /* Livewire components */
        Livewire::component('simple-permission::users-list', UsersList::class);
        Livewire::component('simple-permission::roles-list', RolesList::class);
        Livewire::component('simple-permission::permissions-list', PermissionsList::class);

        /* Register middleware */
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('auth-gates', AuthGates::class);
    }
}
