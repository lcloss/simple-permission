# SimplePermission
SimplePermission is a simple authorization package for Laravel.
It is designed with Laravel 10, but may work with other versions.
With this package, Roles and Permissions are added to your Laravel application, so you can easily manage authorization.

## Installation
1. Install the package via composer:
    ```bash
    composer require lcloss/simple-permission
    ```
2. Publish the config file:
    ```bash
    php artisan vendor:publish --provider="Lcloss\SimplePermission\SimplePermissionServiceProvider"
    ```
   
3. Run the migrations:
    ```bash
    php artisan migrate
    ```
   
4. Add the `HasRoles` trait to your `User` model:
    ```php
    use Lcloss\SimplePermission\Traits\HasRoles;
   
    class User extends Authenticatable
    {
        use HasRoles;
    }
    ```

5. Add the `AuthGate` middleware to your `app\Http\Kernel.php` file:
    ```php
    protected $middlewareGroups = [
        'web' => [
            // ...
            \Lcloss\SimplePermission\Http\Middleware\AuthGate::class,
        ],

        'api' => [
            // ...
            \Lcloss\SimplePermission\Http\Middleware\AuthGate::class,
        ],
    ];
    ```
   
## Configuration

You can change this package's configuration by editing the `config/simple-permission.php` file.

## Database Seeder

This package comes with a database seeder that creates the default roles and permissions.
You can run it with the following command:

```bash
php artisan db:seed --class=SimplePermissionSeeder
```
Or, you can run individual seeders:

```bash
php artisan db:seed --class=SimplePermissionRolesSeeder
php artisan db:seed --class=SimplePermissionPermissionsSeeder
```

## Roles and Permissions

### Roles

This package cames with default roles: 'sysadmin', 'admin', 'premium-user', 'user' and 'free-user'.

Each role has a single identification `slug` and a `level` to determine the role's hierarchy.
Roles with `level` 1 are the highest level roles, and roles with `level` 300 are the lowest level roles.
All roles with `level` 1 get access to all permissions.

You can customize the roles by editing the `database\seeders\SimplePermissionRolesSeeder.php` file.

### Permissions

Permissions follows the structure of `access`, `list` and CRUD operations (`create`, `read`, `update` and `delete`).
Tipically `access` permisison is used to allow access to a resource, `list` permission is used to allow listing the resource, and CRUD permissions are used to allow operations on the resource.

A permission is composed by an `object` and an `action`, delimited by a `_` character.
An object is a resource, like `users`, `roles`, `permissions`, `posts` or `comments`.
An action is an operation on the resource, like `access`, `list`, `create`, `read`, `update` or `delete`.

So, the permission `users_create` determine if the user can create users, and the permission `users_list` determine if the user can list users.

You can customize the permissions by editing the `database\seeders\SimplePermissionPermissionsSeeder.php` file.

To protect a route, you can use the `can` middleware:
```php
Route::get('/users', [UserController::class, 'index'])->middleware('can:users_list');
```

To protect a controller method, you can use the `can` middleware:
```php
use Gate;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('users_list');
        
        // ...
    }
}
```

To protect a part of a view, you can use the `@can` directive:
```blade
@can('users_list')
    <a href="{{ route('users.index') }}">Users</a>
@endcan
```
## TODOs

- [ ] Add tests
- [ ] Add artisan commands
